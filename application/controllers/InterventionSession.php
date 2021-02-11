<?php
date_default_timezone_set('America/New_York');

class InterventionSession extends CI_Controller
{
    /**
     * This method responds to an API request from the frontend by
     * sending all existing intervention sessions that belong to
     * the patient with the given patientId.
     */
    public function get_intervention_sessions()
    {
        $options['patientId'] = $this->input->post('pId');

        $results = $this->InterventionSessionModel->get_incomplete_intervention_sessions_for_patient($options);
        $num_of_activities = $this->ActivitiesModel->get_count_of_all_activities()->result();

        // TODO: Stephen, generate the UI that shows a patient his/her intervention sessions. All required data is in $results.
        $jsonPayload['pkg'] = '';
        $jsonPayload['pkg'].='<h1 class="display-4 mt-4 mb-4 text-center">Interventions</h1>';
        foreach ($results->result() as $row) {
          $options['activityId'] = $row->interventionSessionNextActivityToBePlayed;
          $next_activity = $this->ActivitiesModel->get_activity_name($options)->result()[0]->activityName;

          $jsonPayload['pkg'].=
          '
                  <!-- JUMBOTRON -->
                  <div class= "row">
                  <div class= "col-md-8 offset-md-2">
                  <div class="jumbotron text-left">
                    <div class="container; font-weight-normal">
                      <h3><strong>Session assigned by '. $row->therapistFirstName .' '. $row->therapistLastName .'.<strong></h3>
                        <h6 class="font-italic">assigned on '. date("m/d/Y",strtotime($row->interventionSessionDateAssigned)) .'</h6>

                          <div style="display:inline">
                            <h1 style="display:inline; font-size:100px;">'.$row->interventionSessionActivitiesCompleted.'</h1>
                            <p style="display:inline">of</p>
                            <h2 style="display:inline; font-size:80px">'. $num_of_activities[0]->count .'</h2>
                            <p style="display:inline; font-size:15px">activities completed</p>
                          </div>
                        <div class="container mt-4">
                          <h6 style="display:inline; font-family:georgia"><strong>Next: <strong></h6>
                            <h6 style="display:inline; margin-right:250px">'. $next_activity .' [Level '. $row->interventionSessionCurrentLevelForActivity .']</h6>
                            <button style="display:inline"class="startInterventionButton btn btn-success" iSID="'. $row->interventionSessionId .'">Start</button>
                        </div>
                    </div>
                  </div>
                    </div>
                  </div>
          ';
        }

        $jsonPayload['pkg'].=
        '
          <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
              <button type="button" class="btn btn-primary btn-block" id="back_to_dashboard">Back</button>
            </div>
          </div>
        ';

        echo json_encode($jsonPayload);
        return;
    }

    /**
     * This method starts an Intervention Sessions upon request from
     * the frontend.
     */
    public function start_intervention()
    {
        $options['interventionSessionId'] = $this->input->post('iSID');

        $results = $this->InterventionSessionModel->get_upcoming_activity_details($options);
        $options['levelId'] = $results->result()[0]->interventionSessionCurrentLevelForActivity;
        $activityId = $results->result()[0]->interventionSessionNextActivityToBePlayed;
        $failCounter = $results->result()[0]->failCounterForCurrentActivity;

        $jsonPayload['currentActivity'] = $activityId;
        $jsonPayload['currentLevel'] = $options['levelId'];
        $jsonPayload['failCounter'] = $failCounter;
        $jsonPayload['interventionSessionId'] = $options['interventionSessionId'];

        $options['activityId'] = $activityId;
        $jsonPayload['instructions'] = $this->ActivitiesModel->get_activity_instructions($options)->result()[0]->instructions;
        $jsonPayload['activityName'] = $this->ActivitiesModel->get_activity_name($options)->result()[0]->activityName;

        if(intval($activityId) === 1)
        {
            $level_info = $this->ActivityOneLevelInfoModel->get_level_details($options);
            $jsonPayload['options'] = $level_info->result()[0]->options;
            $jsonPayload['draggable'] = $level_info->result()[0]->draggable;
            $jsonPayload['timer'] = $level_info->result()[0]->timer;
            $jsonPayload['optionOne'] = $level_info->result()[0]->optionOne;
            $jsonPayload['optionTwo'] = $level_info->result()[0]->optionTwo;
            $jsonPayload['optionThree'] = $level_info->result()[0]->optionThree;
            $jsonPayload['answerOne'] = $level_info->result()[0]->answerOne;
            $jsonPayload['answerTwo'] = $level_info->result()[0]->answerTwo;
            $jsonPayload['answerThree'] = $level_info->result()[0]->answerThree;
            $jsonPayload['levelType'] = $level_info->result()[0]->levelType;
        }
        elseif(intval($activityId) === 2)
        {
            // Fetch level information for activity two. Will be implemented when the games are created.
        }

        // Placeholder until games are created.
        /*$jsonPayload['pkg'] =
            '
                <div>
                    <img src="https://spaceplace.nasa.gov/nebula/en/nebula3.en.jpg" class="mx-auto d-flex" alt="nebula">
                    <button type="button" id="stopInterventionButton" class="btn btn-danger btn-block mt-2" iSID="'. $options['interventionSessionId'] .'">STOP</button>
                </div>
            ';*/

        echo json_encode($jsonPayload);
        return;
    }

    /**
     * This method stops an Intervention Session upon request from
     * the frontend.
     */
    public function stop_intervention()
    {
        $options['interventionSessionId'] = $this->input->post('iSID');
        $options['failCounter'] = $this->input->post('failCounter');
        $options['activityId'] = $this->input->post('activityId');

        if(intval($options['failCounter']) === 3)
        {
          $options['levelId'] = 1;
          $options['failCounter'] = 0;

          // Lock activity
          $this->LockedActivitiesModel->insert_activity($options);

          // Update current activity
          $result = $this->ActivitiesModel->get_count_of_all_activities();
          $count = $result->result()[0]->count;
          if($options['activityId'] < $count)
          {
            $options['activityId']++;
          }
          
          $this->InterventionSessionModel->update_activity($options);
        }

        $this->InterventionSessionModel->update_fail_counter($options);

        // Get metric data from frontend and store it in DB. Will be implemented once data recording feature is added.

        // TODO: Peter, generate the UI that shows the patient his/her progress after stopping a session.
        // For now, use mock data. Once the use case in the comment above is implemented, we'll then use
        // the recorded data for the summary.
        $jsonPayload['pkg'] =
            '
            <div class="row">
              <div class="col-md-8 offset-md-2">
                <div class="jumbotron">
                  <div class="mx-auto dflex">
                    <div class="row">
                      <div class="col">
                        <div>
                          <h1>Summary</h1>
                        </div>
                        <p>Duration: 12 minutes</p>
                        <p>Activities completed: 0</p>
                        <p>Levels cleared: 2</p>
                      </div>
                      <div class="col offset-3">
                          <img src="https://www.shareicon.net/data/512x512/2016/08/04/806673_school_512x512.png" width="150" height="150" alt="Return Home." class="img-responsive">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col offset-10">
                        <button type="button" id="homeButton" class="btn btn-primary" title="Return to Intervention Session.">Home</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            ';

        echo json_encode($jsonPayload);
        return;
    }

    /**
     * This method creates the intervention session assigned
     * to a Patient by a Therapist. 
     */
    public function create_intervention_session()
    {
      $options['patientId'] = $this->input->post('pId');
      $options['therapistId'] = $this->input->post('tId');
      $options['dateAssigned'] = date("Y-m-d");

      $this->InterventionSessionModel->create_intervention_session($options);
      $patient = $this->PatientModel->get_patient_information($options)->result()[0];
      $therapist = $this->TherapistModel->get_therapist_information($options)->result()[0];

      $data['patientName'] = $patient->patientFirstName .' '. $patient->patientLastName;
      $data['therapistName'] = $therapist->therapistFirstName .' '. $therapist->therapistLastName;
      $data['date'] = date("m/d/Y");

      $this->load->view('session_assigned', $data);
    }

    /**
     * This method locks an intervention session activity once
     * the patient has failed the activity thrice.
     */
    public function lock_activity()
    {
      $options['interventionSessionId'] = $this->input->post('iSID');
      $options['activityId'] = $this->input->post('activityId');
      $options['levelId'] = 1;
      $options['failCounter'] = 0;

      // Lock activity
      $this->LockedActivitiesModel->insert_activity($options);

      // Update current activity
      $result = $this->ActivitiesModel->get_count_of_all_activities();
      $count = $result->result()[0]->count;
      if($options['activityId'] < $count)
      {
        $options['activityId']++;
      }
      
      $this->InterventionSessionModel->update_activity($options);
      $this->InterventionSessionModel->update_fail_counter($options);
      $jsonPayload['interventionSessionId'] = $options['interventionSessionId'];

      echo json_encode($jsonPayload);
      return;
    }

    /**
     * This method handles the case whereby an activity's level has been passed.
     */
    public function level_passed()
    {
      $options['interventionSessionId'] = $this->input->post('iSID');
      $options['activityId'] = $this->input->post('activityId');
      $options['levelId'] = $this->input->post('level');

      if($options['activityId'] == 1)
      {
        $result = $this->ActivityOneLevelInfoModel->get_count_of_all_levels();
        $count = $result->result()[0]->count;
        if($options['levelId'] < $count) // Update level if more exist for current activity.
        {
          $options['levelId']++;
          $this->InterventionSessionModel->update_activity($options);
        }
        else  // Update the activity to the next one to be played.
        {
          $this->InterventionSessionModel->increment_activities_completed($options);
          $activity_result = $this->ActivitiesModel->get_count_of_all_activities();
          $activity_count = $activity_result->result()[0]->count;
          if($options['activityId'] < $count) // Update activity if more exist in current session.
          {
            $options['activityId']++;
            $options['levelId'] = 1;
            $options['failCounter'] = 0;
            $this->InterventionSessionModel->update_fail_counter($options);
            $this->InterventionSessionModel->update_activity($options);
          }
          else // $options['activityId'] == $count
          {
            //check for locked activities
            $locked_activities = $this->LockedActivitiesModel->get_locked_activities($options);
            if($locked_activities->num_rows() > 0)
            {
              $options['activityId'] = $locked_activities->result()[0]->lockedActivityActivityId;
              $options['levelId'] = 1;
              $options['failCounter'] = 0;
              $this->InterventionSessionModel->update_fail_counter($options);
              $this->InterventionSessionModel->update_activity($options);
            }
            else // if none exist, session is complete. Update session and redirect patient.
            {
              $this->InterventionSessionModel->update_session_completion_status($options);
              $jsonPayload['session_done'] = true;
            }  
          }
        }
      }

      $jsonPayload['interventionSessionId'] = $options['interventionSessionId'];

      echo json_encode($jsonPayload);
      return;
    }
}
