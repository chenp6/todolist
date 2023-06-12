<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    /**
     * [GET] home/helloWorld
     * 
     * Get home page.
     *
     * @return void
     */
    public function helloWorld()
    {
        $data = [
            'title'      => 'Hello World',
            'todo_list'  => [
                'Clean House', 'Call Mom', 'Run Errands'
            ]
        ];

        $data['heading'] = 'I\'m a heading';

        return view('helloWorld', $data);
    }

    public function tableLab()
    {
        $data = [
            'title'      => 'Table LAB',
            'heading'    => 'SDLC',
            'todo_list'  => [
                'Week_1' => [
                    'Requirement Gathering and Analysis',
                    'You should analysis relevant requirement and create SRS (Software Requirement Specification) file.',
                ],
                'Week_2' => [
                    'Design',
                    'Following the SRS to design the software architecture (OOD) and technology selection.',
                ],
                'Week_3' => [
                    'Implementation or Coding',
                    'Following the SRS and above design to implement your project (OOP) .',
                ],
                'Week_4' => [
                    'Testing',
                    'Following the SRS and above design to test your project and fix the bug to achieve the client requirement.',
                ],
                'Week_5' => [
                    'Deployment',
                    'Deployment your project under the UAT (User Acceptance Testing) environment.',
                ],
                'Week_6' => [
                    'Maintenance',
                    'Following the the SRS to maintain your project.',
                ],
            ]
        ];

        return view('tableLab', $data);
    }

    /**
     * [GET] home/helloJson
     * 
     * Get Json type return data.
     *
     * @return void
     */
    public function helloJson()
    {
        $this->response->setStatusCode(200);

        return $this->response->setJSON([
            'msg' => 'Hello Json API.'
        ]);
    }
}
