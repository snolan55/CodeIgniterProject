<?php
class UserManagement extends CI_Controller
{
    /**
     * This method loads the UI for assigning an intervention.
     */
    public function pull_assign_page()
    {
        /* CASE: Signed in as a Therapist */
        if ($this->session->userdata('accountType') == 'therapist')
        {
            $this->load->view('session_assign');
        }
        /* CASE: Trying to access page while logged out */
        elseif ($this->session->userdata('accountType') == '')
        {
            redirect(base_url() . 'index.php/System/login');
        }
        /* CASE: Signed in as a Patient or an Administrator */
        else
        {
            if($this->session->userdata('accountType') == 'patient')
            {
                redirect(base_url() . 'index.php/Dashboard/patient');
            }
            /* accountType == 'admin' */
            else
            {
                $this->load->view('patient_view');
            }
        }

    }

    /**
     * This method dynamically generates a portion of the
     * session_assign view based on the currently selected patient.
     */
    public function get_patient_information()
    {
        $options['patientId'] = $this->input->post('pId');
        $options['therapistId'] = $this->input->post('tId');

        $patient = $this->PatientModel->get_patient_information($options)->result()[0];
        $incomplete_sessions = $this->InterventionSessionModel->count_of_all_incomplete_sessions($options)->result()[0]->count;

        /* TODO: Amanda, the second part of the session_assign view (with the patient's information) is created here.
        You can create the HTML in the string below. Before you actually create the bootstrap jumbotron, create two
        input elements with type="hiden". One should have the attribute name="pId" and the other name="tId". The value of these should be the patient and therapist's ID respectfully. You can access the IDs from the options object above. That is, $options['patientId] etc...
        Once you start making the page for the patient's information, you can access the patient's information from the $patient object. That is, $patient->patientFirstName etc... The number of incomplete sessions is the variable above.
        */
        $jsonPayload['pkg'] =
            '
             <input type="hidden" name="pId" value="'.$options['patientId'].'">
             <input type="hidden" name="tId" value="'.$options['therapistId'].'">

                <div class="jumbotron" style="margin-top: 20px;">
                  <div class="mx-auto dflex">
                    <div class="jumbotron text-left"
                      <div class="row">
                        <div class="col">
                        <div>
                          <h4 style="font-size:20px">Patient Information</h4>
                          </div>
                          <p style="font-size:15px"><strong>Name:</strong> '.$patient->patientFirstName.' '.$patient->patientLastName.'</p>
                          <p style="font-size:15px"><strong>Date of Birth:</strong> '. date("m/d/Y", strtotime($patient->patientDateOfBirth)) .'</p>
                          <p style="font-size:15px"><strong>Number of Incomplete Sessions:</strong> '.$incomplete_sessions.'</p>
                            <div class="col offset-10">
                            <button type="button" id="assignButton" class="btn btn-primary" title="Assign an Intervention Session.">Assign</button>
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
    public function get_patient_information2()
    {
        $options['patientId'] = $this->input->post('pId');
        $options['therapistId'] = $this->input->post('tId');

        $patient = $this->PatientModel->get_patient_information($options)->result()[0];
        $incomplete_sessions = $this->InterventionSessionModel->count_of_all_incomplete_sessions($options)->result()[0]->count;

        /* TODO: Amanda, the second part of the session_assign view (with the patient's information) is created here.
        You can create the HTML in the string below. Before you actually create the bootstrap jumbotron, create two
        input elements with type="hiden". One should have the attribute name="pId" and the other name="tId". The value of these should be the patient and therapist's ID respectfully. You can access the IDs from the options object above. That is, $options['patientId] etc...
        Once you start making the page for the patient's information, you can access the patient's information from the $patient object. That is, $patient->patientFirstName etc... The number of incomplete sessions is the variable above.
        */
        $jsonPayload['pkg'] =
            '
             <input type="hidden" name="pId" value="'.$options['patientId'].'">


                <div class="jumbotron" style="margin-top: 20px;">
                  <div class="mx-auto dflex">
                    <div class="jumbotron text-left"
                      <div class="row">
                        <div class="col">
                        <div>
                          <h4 style="font-size:20px">Patient Information</h4>
                          </div>
                          <p style="font-size:15px"><strong>Name:</strong> '.$patient->patientFirstName.' '.$patient->patientLastName.'</p>
                          <p style="font-size:15px"><strong>Date of Birth:</strong> '. date("m/d/Y", strtotime($patient->patientDateOfBirth)) .'</p>
                          <p style="font-size:15px"><strong>Number of Incomplete Sessions:</strong> '.$incomplete_sessions.'</p>
                            <div class="col offset-10">
                            <button type="button" id="downloadButton" class="btn btn-primary" title="Download a Patient File.">Download</button>
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
     * This method retrieves the names of patients that are similar to
     * whatever is typed in the search bar. It is the source for the typeahead's
     * functionality of the search bar.
     */
    public function get_patient_fname_lname()
    {
        $options['patientFullName'] = $this->input->post('query');
        $options['therapistId'] = $this->input->post('tId');

        $results = $this->PatientModel->get_patient_fname_lname($options);

        $data = array();
        foreach ($results->result() as $row)
        {
            $data[] = array('id' => $row->patientId, 'name' => $row->patientFirstName. ' ' .$row->patientLastName);
        }

        echo json_encode($data);
        return;
    }

    public function create_new_patient()
    {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('patientFirstName', 'patientFirstName', 'required|alpha');
      $this->form_validation->set_rules('patientLastName', 'patientLastName', 'required|alpha');
      $this->form_validation->set_rules('patientDateOfBirth', 'patientDateOfBirth', 'required');
      $this->form_validation->set_rules('patientUsername', 'patientUsername', 'required|is_unique[patients.patientUsername]');
      $this->form_validation->set_rules('patientPassword', 'patientPassword', 'required');

      if ($this->form_validation->run() == FALSE)
      {
        $this->load->view('patient_registration');
      }
      else
      {
        $options['patientFirstName'] = $this->input->post('patientFirstName');
        $options['patientLastName'] = $this->input->post('patientLastName');
        $options['patientDateOfBirth'] = $this->input->post('patientDateOfBirth');
        $options['userId'] = $this->input->post('userId');
        $options['patientUsername'] = $this->input->post('patientUsername');
        $options['patientPassword'] = $this->input->post('patientPassword');

        $this->PatientModel->create_new_patient($options);


        $this->load->view('registration_complete');
      }
    }

    public function create_new_therapist()
    {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('therapistFirstName', 'therapistFirstName', 'required|alpha');
      $this->form_validation->set_rules('therapistLastName', 'therapistLastName', 'required|alpha');
      $this->form_validation->set_rules('therapistUsername', 'therapisttUsername', 'required|is_unique[therapists.therapistUsername]');
      $this->form_validation->set_rules('therapistPassword', 'therapistPassword', 'required');

      if ($this->form_validation->run() == FALSE)
      {
        $this->load->view('therapist_registration');
      }
      else {

        $options['therapistFirstName'] = $this->input->post('therapistFirstName');
        $options['therapistLastName'] = $this->input->post('therapistLastName');
        $options['userId'] = $this->input->post('userId');
        $options['therapistUsername'] = $this->input->post('therapistUsername');
        $options['therapistPassword'] = $this->input->post('therapistPassword');

        $this->TherapistModel->create_new_therapist($options);
        $this->load->view('registration_complete');
      }
    }

    public function pull_progress_page()
    {
        if (($this->session->userdata('accountType') == 'therapist') || ($this->session->userdata('accountType') == 'admin')) {
            $this->load->view('patient_progress');
        }
        elseif ($this->session->userdata('accountType') == 'patient') {
            redirect(base_url() . 'index.php/Dashboard/patient');
        }
        else {
            redirect(base_url() . 'index.php/System/login');
        }
    }



    public function get_patient_progress()
    {
        $options['patientId'] = $this->input->post('pId');
        $options['therapistId'] = $this->input->post('tId');

        $patient = $this->PatientModel->get_patient_information($options)->result()[0];
        $completed_activities = $this->ActivityMetricsModel->number_of_completed_activities($options)->result()[0];
        $results = $this->ActivityMetricsModel->get_patient_progress($options);
        $num_of_activities = $this->ActivitiesModel->get_count_of_all_activities()->result();
        $act_prog = ($completed_activities->interventionSessionActivitiesCompleted) * (100/($num_of_activities[0]->count));

        $jsonPayload['pkg'] = '';
        $jsonPayload['pkg'].=
            '
            <input type="hidden" name="pId" value="'.$options['patientId'].'">
            <input type="hidden" name="tId" value="'.$options['therapistId'].'">

            <div class="container" style="margin-top: 10px; margin-bottom: 20px;">
              <div class="mx-auto dflex">
                <div class="container text-left"
                  <div class="row">
                    <div class="col">
                      <div>
                        <h4 style="font-size:20px"><strong>Name:</strong> '.$patient->patientFirstName.' '.$patient->patientLastName.'</h4>
                      </div>
                      <div class="progress" style="height: 40px;">
                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="'.$act_prog.'"
                          aria-valuemin="0" aria-valuemax="100" style="width:'.$act_prog.'%">
                          '. $completed_activities->interventionSessionActivitiesCompleted .' of '. $num_of_activities[0]->count .' activities completed.
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            '
        ;



        foreach ($results->result() as $row) {
          $options['activityId'] = $row->activityMetricsActivityId;
          $activity_name = $this->ActivitiesModel->get_activity_name($options)->result()[0]->activityName;
          $min = floor($row->activityTime/60);
          $sec = ($row->activityTime) - ($min * 60);

          $jsonPayload['pkg'].=
          '
          <div class= "row">
            <div class= "col-md-8 offset-md-2">
              <div class="jumbotron text-left">
                <div class="container; font-weight-normal">
                  <h4><strong>'. $activity_name .' Activity: Attempt '.$row->activityAttempt.'<strong></h4>
                  <div class="container mt-4">
                    <h4 style="font-size:18px">Time to Complete Activity:<strong></strong></h4>
                    <div><canvas id="myTimeChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.'"></canvas></div>
                  </div>
                  <div class="container mt-4">
                    <h4 style="font-size:18px">Accuracy:<strong></strong></h4>
                    <div><canvas id="myScoreChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.'"></canvas></div>
                    <script>
                      Chart.pluginService.register({
                        beforeDraw: function(chart) {
                          if (chart.config.type == "doughnut") {
                            if (chart.config.options.elements.center) {
                              //Get ctx from string
                              var ctx = chart.chart.ctx;

                              //Get options from the center object in options
                              var centerConfig = chart.config.options.elements.center;
                              var fontStyle = centerConfig.fontStyle || "Arial";
                              var txt = centerConfig.text;
                              var color = centerConfig.color || "#000";
                              var maxFontSize = centerConfig.maxFontSize || 25;
                              var sidePadding = centerConfig.sidePadding || 20;
                              var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                              //Start with a base font of 30px
                              ctx.font = "30px " + fontStyle;

                              //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                              var stringWidth = ctx.measureText(txt).width;
                              var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                              // Find out how much the font can grow in width.
                              var widthRatio = elementWidth / stringWidth;
                              var newFontSize = Math.floor(30 * widthRatio);
                              var elementHeight = (chart.innerRadius * 2);

                              // Pick a new font size so it will not be larger than the height of label.
                              var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);

                              //Set font settings to draw it correctly.
                              ctx.textAlign = "center";
                              ctx.textBaseline = "middle";
                              var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                              var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                              ctx.font = fontSizeToUse + "px " + fontStyle;
                              ctx.fillStyle = color;

                              //Draw text in center
                              ctx.fillText(txt, centerX, centerY);
                            }
                          }
                        }
                      });
                      var ctxt = document.getElementById(\'myTimeChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.'\').getContext(\'2d\');
                      var timeChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.' = new Chart(ctxt, {
                        type:"doughnut",
                        labels:["",""],
                        data:{
                          datasets:[{
                            backgroundColor: [
                              \'rgba(54, 162, 235, 1)\',
                              \'rgba(54, 162, 235, 0.2)\',
                            ],
                            data:['.$row->activityTime.', '.(360-($row->activityTime)).']
                          }]
                        },
                        options: {
                          elements: {
                            center: {
                              text: "'.$min.'m '.$sec.'s",
                              color: "#FF6384", // Default is #000000
                              fontStyle: "Arial", // Default is Arial
	                            maxFontSize: 30, // Default is 25
	                            sidePadding: 20 // Defualt is 20 (as a percentage)
	                           }
                           },
                          title: {
                            display: true,
                          }
                        }
                      });
                      var ctxs = document.getElementById(\'myScoreChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.'\').getContext(\'2d\');
                      var scoreChart_'.$row->activityMetricsActivityId.'_'.$row->activityAttempt.' = new Chart(ctxs, {
                        type:\'doughnut\',
                        labels:["",""],
                        data: {
                          datasets:[{
                            backgroundColor: [
                              \'rgba(46, 198, 99, 1)\',
                              \'rgba(245, 122, 122, .1)\',
                            ],
                            data:['.$row->activityScore.', '.(100-($row->activityScore)).']
                          }]
                        },
                        options: {
                          elements: {
                            center: {
                              text: "'.$row->activityScore.'% Accurate.",
                              color: "#FF6384", // Default is #000000
                              fontStyle: "Arial", // Default is Arial
	                            maxFontSize: 30, // Default is 25
	                            sidePadding: 20 // Defualt is 20 (as a percentage)
	                           }
                           },
                           title: {
                             display: true,
                           }
                         }
                       });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
          ';
        }


        echo json_encode($jsonPayload);
        return;
    }
}
