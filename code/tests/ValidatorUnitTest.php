<?php

use App\Http\Controllers\API\V1\Task\TaskController;
use App\Validators\RateTaskValidator;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ValidatorUnitTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * @var \App\Validators\ValidatorInterface
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

        // Do your extra thing here
    }

    private function createValidObject(): void
    {
        $this->validator = new RateTaskValidator();
        $this->validator->setStudentId(1);
        $this->validator->setTaskId(1);
        $this->validator->setRating(1);
    }

    public function testSuccess()
    {
        $this->createValidObject();

        $result = $this->validator->validate();

        $this->assertTrue($result);
    }

    public function testUnvalidStudent()
    {
        $this->createValidObject();
        $unvalidId = 99999999; //todo
        $this->validator->setStudentId($unvalidId);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidTask()
    {
        $this->createValidObject();
        $unvalidId = 99999999; //todo
        $this->validator->setTaskId($unvalidId);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidRatingLessThanMin()
    {
        $this->createValidObject();
        $this->validator->setRating(TaskController::MIN_RAITNG - 1);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function testUnvalidRatingMoreThanMax()
    {
        $this->createValidObject();
        $this->validator->setRating(TaskController::MAX_RATING + 1);
        $result = $this->validator->validate();

        $this->assertFalse($result);
    }

    public function tearDown(): void
    {
        // do not remove this function
    }
}
