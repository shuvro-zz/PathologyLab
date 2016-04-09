<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OperatorReportsTest extends TestCase {

    use DatabaseTransactions;

    public function testReportPageNavigation() {
        $operator = $this->createOperator();
        $this->actingAs($operator)
            ->visit('dashboard')
            ->seePageIs('dashboard')
            ->see('List of reports');
    }

    public function testCreateNewReport() {
        $operator = $this->createOperator();
        $patient  = $this->createPatient();
        // visit the create New Report Page
        $this->actingAs($operator)->visit('report/create')->seePageIs('report/create')
            // provide all the parameters
            ->select($patient->id, 'patient')
            ->type('Sugar Level Test', 'reportname')
            ->type('01-01-2016', 'testdate')
            ->type('XYZ Labs', 'testedby')
            ->type('lorem ipsum', 'history')
            ->type('Random report details', 'reportdetails')
            ->type('Some Additional details', 'additionaldetails')
            // click the submit button
            ->press("Save Report")
            // check if the new report is in database
            ->seeInDatabase("reports", [
                "user_id"     => $patient->id,
                "report_name" => 'Sugar Level Test',
                "testing_lab" => "XYZ Labs"]
            )
            // check if the dashboard contains the new patient and the reports details
            ->seePageIs("dashboard")->see($patient->name)->see("Sugar Level Test")->see("Random report details");
    }

    public function testValidateCreateNewReport() {
        $operator = $this->createOperator();
        $patient  = $this->createPatient();
        // visit the create New Report Page
        $this->actingAs($operator)->visit('report/create')->seePageIs('report/create')
            // submit the form without patient
            ->select("", "patient")->type("01-01-2016", "testdate")->type("XYZ Labs", "testedby")
            ->type("lorem ipsum", "history")->type("report details", "reportdetails")->type("somerandomname", "reportname")
            ->press("Save Report")->seePageIs("report/create")->see("The patient field is required")

            // submit the form without reportname
            ->select($patient->id, "patient")->type("01-01-2016", "testdate")->type("XYZ Labs", "testedby")
            ->type("lorem ipsum", "history")->type("report details", "reportdetails")->type("", "reportname")
            ->press("Save Report")->seePageIs("report/create")->see("The reportname field is required")

            // submit the form with wrong date format
            ->select($patient->id, "patient")->type("01-01-2016 09:09:24", "testdate")->type("XYZ Labs", "testedby")
            ->type("lorem ipsum", "history")->type("report details", "reportdetails")->type("rerasfd asdfs", "reportname")
            ->press("Save Report")->seePageIs("report/create")->see("The testdate does not match the format d-m-Y")

            // submit the form without any params
            ->select("", "patient")
            ->type("", "testdate")
            ->type("", "reportname")
            ->type("", "reportdetails")
            ->type("", "testedby")
            ->press("Save Report")->seePageIs("report/create")
            ->see("The patient field is required")
            ->see("The reportname field is required")
            ->see("The reportdetails field is required")
            ->see("The testdate field is required")
            ->see("The testedby field is required");
    }

    public function testEditReport() {
        $operator = $this->createOperator();
        $patient  = $this->createPatient();
        $report   = $this->createReport($patient);
        // login as operator
        
        $this->actingAs($operator)
            // go to the edit report page
            ->visit("report/$report->id/edit")->see("Edit Report")->see($patient->name);
        // change the report details
        // submit form
        // check if the new report are in the database
        // check if the new report details are on the webpage
    }

    public function testDeleteReport() {
        $operator = $this->createOperator();
        // login as the operator
        // create a report
        // go to the dashboard
        // click on the delete button for the report
        // check that you dont see the report in the webpage
        return false;
    }

    public function testViewReport() {
        $operator = $this->createOperator();
        // create a patient
        // create a report
        // click on the view report button
        // see if you see the patient and the report on the webpage
        return false;
    }

    public function testEmailReport() {
        $operator = $this->createOperator();
        return false;
    }

    public function testPDFReport() {
        $operator = $this->createOperator();
        return false;
    }

    public function testDownloadReport() {
        $operator = $this->createOperator();
        return false;
    }

    private function createReport($patient) {
        $report = factory(App\Report::class)->create([
            "user_id" => $patient->id
        ]);
        
        file_put_contents('filename.txt',print_r($report,true));
        return $report;
    }

    /**
     * Create Operator
     * @return App\User
     */
    private function createOperator() {
        $operator = factory(App\User::class)->create([
            "name"        => "test",
            "email"       => "test@test.com",
            "password"    => "12345",
            "passcode"    => "12345",
            "is_operator" => '1']
        );
        return $operator;
    }

    /**
     * Create Patient
     * @return App\User
     */
    private function createPatient() {
        $patient = factory(App\User::class)->create([
            "name"        => "thisisauniquepatientname",
            "email"       => "patient@test.com",
            "password"    => "password",
            "passcode"    => "password",
            "is_operator" => '0']
        );
        return $patient;
    }

}