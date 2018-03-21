<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

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
        $data['title'] = 'California Cannabis Awards - An Industry Networking Event';
        $data['description'] = 'The first cannabis award show of its kind. The CCA awards take place in so-cal & nor-cal. Join us for a night of networking & performances as we award the best in the industry!';
        $data['cononical'] = 'http://www.californiacannabisawards.com/';
        $this->load->view('includes/header', $data);
        $this->load->view('home', $data);
        $this->load->view('includes/footer', $data);
    }
}