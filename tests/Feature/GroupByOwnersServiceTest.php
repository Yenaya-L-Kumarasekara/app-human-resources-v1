<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupByOwnersServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testGroupByOwners()
    {

        $files = [
            "insurance.txt" => "Company A",
            "letter.docx" => "Company A",
            "Contract.docx" => "Company B",
        ];

        $result = $this->groupByOwners($files);

        $expectedResult = [
            "Company A" => ["insurance.txt", "letter.docx"],
            "Company B" => ["Contract.docx"],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function groupByOwners(array $files)
    {
        $result = [];

        foreach ($files as $file => $owner) {
            $result[$owner][] = $file;
        }

        return $result;
    }
}
