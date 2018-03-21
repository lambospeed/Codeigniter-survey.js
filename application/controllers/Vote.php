<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vote extends CI_Controller
{
    /*
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('categories_model');
        $this->load->model('nominees_model');
        $this->load->model('voters_model');
        $this->load->model('votes_model');
    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        //get all categories and nominees data from the database
        $categories = $this->categories_model->get_all();
        $nominees = $this->nominees_model->get_all();
        
        //array to make survey json.
        $arrData['name'] = 'page1';
        $arrData['elements'] = array();
        $arrCat = array();
        $arrNominee = array();
        $arrTemp = array();

        //arrange the nominees by their categories
        foreach ($nominees as $nominee) {
            $arrTemp[$nominee['category_id']][$nominee['id']] = $nominee;
        }

        //make array by category
        foreach ($categories as $category) {
            $arrCat['type'] = "radiogroup";
            $arrCat['name'] = $category['id'];
            $arrCat['title'] = $category['name'];
            $arrCat['isRequired'] = $category['required'] == 1? true : false;
            $arrCat['choices'] = array();
            $arrCat['colCount'] = 4;
            $arrCat['hasOther'] = true;
            foreach ($arrTemp[$category['id']] as $nominee) {
                $arrNominee['value'] = $nominee['id'];
                $arrNominee['text'] = $nominee['name'];
                array_push($arrCat['choices'], $arrNominee);
            }
            array_push($arrData['elements'], $arrCat);
        }

        //make a voter user info.
        array_push($arrData['elements'], $this->make_QuestionArray('text','voter_firstname', 'First Name', 'text'));
        array_push($arrData['elements'], $this->make_QuestionArray('text','voter_lastname', 'Last Name', 'text'));
        array_push($arrData['elements'], $this->make_QuestionArray('text','voter_email', 'Email', 'email'));
        array_push($arrData['elements'], $this->make_QuestionArray('text','voter_phonenumber', 'Phone Number', 'numeric'));
        
        //make a final array to make survey json.
        $data['surveyJSON'] = array('pages' => array($arrData));
        $data['title'] = "CCA's - Place Your Vote Today!";
        $data['description'] = 'Register and place your vote for the first annual California Cannabis Awards!';
        $data['cononical'] = 'http://www.californiacannabisawards.com/';
        
        //Rendering
        $this->load->view('includes/header', $data);
        $this->load->view('awards/vote', $data);
        $this->load->view('includes/footer', $data);
    }

    /*
    * Function: get the ajax data from survey result
    */
    public function getsurvey() {
        //get all post data.
        $postData = $this->input->post();
        //insert voter to the voters table.
        $voterData = array(
            'first_name' => $postData['voter_firstname'],
            'last_name' => $postData['voter_lastname'],
            'email' => $postData['voter_email'],
            'phone_number' => $postData['voter_phonenumber']
        );
        $voter_id = $this->voters_model->insert($voterData);
        
        foreach ($postData as $key => $value) {
            if (substr($key, 0, 6) == 'voter_' || substr($key, -8) == '-Comment')
                continue;
            if ($value == 'other') {
                $nomineeData = array(
                    'name' => $postData[$key . '-Comment'],
                    'category_id' => $key
                );
                $nominee_id = $this->nominees_model->get_by($nomineeData);
                if (is_null($nominee_id))
                    $nominee_id = $this->nominees_model->insert($nomineeData);
                $voteData = array(
                    'voter_id' => $voter_id,
                    'category_id' => $key,
                    'nominee_id' => $nominee_id
                );
                $vote_id = $this->votes_model->insert($voteData);
            } else {
                $voteData = array(
                    'voter_id' => $voter_id,
                    'category_id' => $key,
                    'nominee_id' => $value
                );
                $vote_id = $this->votes_model->insert($voteData);
            }
        }
        exit('success');
    }

    /*
    * Function: See how many votes each nomination has from each category
    */
    public function view() {

        $user_id = $this->session->userdata('user_id');
        if (!$this->session->userdata('logged_in'))
            redirect('user/login');
        //get all categories and nominees data from the database
        $categories = $this->categories_model->get_all();
        $nominees = $this->nominees_model->get_all();
        $voters = $this->voters_model->get_all();

        //get vote count for each nominations.
        $voteResult = $this->votes_model->getAllCountByNominees();
        

        //arrange the voting Result by their categories
        $arrResult = array();
        foreach ($voteResult as $row) {
            $arrResult[$row['category_id']][$row['nominee_id']] = $row;
        }

        //arrange the nominees by their id
        $arrNominee = array();
        foreach ($nominees as $nominee) {
            $arrNominee[$nominee['id']] = $nominee['name'];
        }

        //arrange the categories by their id
        $arrCategory = array();
        foreach ($categories as $category) {
            $arrCategory[$category['id']] = $category['name'];
        }
        $data['categories'] = $arrCategory;
        $data['nominees'] = $arrNominee;
        $data['voteResult'] = $arrResult;
        $data['title'] = "View Nominees";
        $data['description'] = 'See how many votes each nomination has from each category!';
        $data['cononical'] = 'http://www.californiacannabisawards.com/';
        
        //Rendering
        $this->load->view('includes/header', $data);
        $this->load->view('awards/view', $data);
        $this->load->view('includes/footer', $data);
    }

    function make_QuestionArray($type, $name, $title, $validation) {
        $arrData = array();
        $arrData['type'] = $type;
        $arrData['name'] = $name;
        $arrData['title'] = $title;
        $arrData['isRequired'] = true;
        $arrData['validators'] = array(
            "type" => $validation
        );
        return $arrData;
    }
}