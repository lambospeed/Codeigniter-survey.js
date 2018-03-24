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
        $data['surveyJSON'] = array('cookieName' => 'mySurveyCookie', 'pages' => array($arrData));
        $data['title'] = "CCA's - Place Your Vote Today!";
        $data['description'] = 'Register and place your vote for the first annual California Cannabis Awards!';
        $data['cononical'] = 'http://www.californiacannabisawards.com/';
        $data['headerTitle'] = "Place Your Votes!";

        //Rendering
        $this->load->view('includes/header', $data);
        $this->load->view('awards/vote', $data);
        $this->load->view('includes/footer', $data);
    }

    /*
    * Function: vote page for every nominees in dispensary category
    * By this url, users can vote only for the specific nominee in dispensary
    * @params: $nominee ---- nominee name to vote.
    */
    public function page($nominee) {

        //Check if this nominee is the dispensary in the database.
        $arrNominee = array(
            'name' => urldecode($nominee)
        );
        //pull data from the nominees table/
        $nomineeData = $this->nominees_model->get_by($arrNominee);
        //array that can be rendered on survey.js.
        $arrData = array();
        if (!empty($nomineeData)) {
            //array to make survey json.
            $arrData['name'] = 'page1';
            $arrData['elements'] = array();
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
            $data['headerTitle'] = $nomineeData['name'];
            $data['nominee_id'] = $nomineeData['id'];
            $data['category_id'] = $nomineeData['category_id'];
            
            //Rendering
            $this->load->view('includes/header', $data);
            $this->load->view('awards/vote', $data);
            $this->load->view('includes/footer', $data);
        }
            
    }

    /*
    * Function: get the ajax data from survey result
    */
    public function getsurvey() {
        //get all post data.
        $postData = $this->input->post();
        // //get client ip address.
        // $client_ip = $this->get_client_ip();
        
        //check if the additional page or vote page.
        //If this is additional page, they don't use guid for identify device.
        if (isset($postData['additional'])) {
            //insert voter to the voters table.
            $voterData = array(
                'first_name' => $postData['voter_firstname'],
                'last_name' => $postData['voter_lastname'],
                'email' => $postData['voter_email'],
                'phone_number' => $postData['voter_phonenumber'],
            );
            $query = array(
                'email' => $postData['voter_email']
            );
        } else {
            //insert voter to the voters table.
            $voterData = array(
                'first_name' => $postData['voter_firstname'],
                'last_name' => $postData['voter_lastname'],
                'email' => $postData['voter_email'],
                'phone_number' => $postData['voter_phonenumber'],
                'guid' => $postData['guid']
            );
            // query to find the voter who has already exist in database or guid is already in database.
            $query = "email='" . $postData['voter_email'] . "' OR guid='" . $postData['guid'] . "'";
        }
        $voter_exist = $this->voters_model->get_by($query);
        if (!empty($voter_exist))
            exit("voter_exist");
        else
            $voter_id = $this->voters_model->insert($voterData);
        
        foreach ($postData as $key => $value) {
            if (substr($key, 0, 6) == 'voter_' || substr($key, -8) == '-Comment' || $key == 'guid')
                continue;
            if ($value == 'other') {
                $nomineeData = array(
                    'name' => $postData[$key . '-Comment'],
                    'category_id' => $key
                );
                //Pull existing data from the nominees table.
                $nominee_exist = $this->nominees_model->get_by($nomineeData);
                if (empty($nominee_exist))
                    $nominee_id = $this->nominees_model->insert($nomineeData);
                else
                    $nominee_id = $nominee_exist['id'];
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

    function get_client_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}