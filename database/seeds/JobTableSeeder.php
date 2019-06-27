<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

use App\Models\Job;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        Job::insert([
            [
                "title" => "Sales Manager",
                "summary" => "Sales Manager with 10yrs experience in FCMG field",
                "expiryDate" => "08/01/2019",
                "salary"=> "6.5 - 10Million p/a",
                "additionalCompetencies" => "Finance",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "You will lead a team of 5 sales associate",
                "experience" => "at least 3yrs post grauduate experience",
                "location" => "Abuja",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "5",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ],[
                "title" => "Chemistry Teacher",
                "summary" => "A Knowledgeable and vibrant Chemistry teacher for our senior secondary class",
                "expiryDate" => "07/01/2019",
                "salary" => "1.5 - 2Million p/a",
                "additionalCompetencies" => "Ability to teach at least one other science subject",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "Teach chemistry to ss1-ss3 students, Organize practical classes for ss3 students",
                "experience" => "at least 3yrs post grauduate experience",
                "location" => "Lagos",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "1",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ],
            [
                "title" => "Senior backend Developer",
                "summary" => "Software developer competent in Golang, C# and at least on scripting language: python preferred",
                "expiryDate" => "07/07/2019",
                "salary" => "5.5 - 10Million p/a",
                "additionalCompetencies" => "5 years experience in Java",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "You will lead a team of 5 junior devs",
                "experience" => "5 years experience in c#",
                "location" => "Lagos",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "2",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ],[
                "title" => "Frontend Developer",
                "summary" => "Software developer competent in one of React/Angular/Vue",
                "expiryDate" => "06/30/2019",
                "salary" => "3.5 - 5Million p/a",
                "additionalCompetencies" => "2 years experience in UI/UX",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "You implement mockups",
                "experience" => "3years experience in working with SPAs",
                "location" => "Lagos",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "2",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ],[
                "title" => "Social Media Executive",
                "summary" => "Proficient in Email Marketing, Social media Marketing and pushing our brand on multiple social media platforms",
                "expiryDate" => "08/01/2019",
                "salary" => "1.2 - 1.5Million p/a",
                "additionalCompetencies" => "Knowlege of search engine optimization will be an added advantage",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "You will be in charge of all how social media platform. You will market our services through social media to reach our target audience",
                "experience" => "minimum 2yrs prior experience",
                "location" => "Oyo",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "9",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ],[
                "title" => "DevOps Engineer",
                "summary" => "DevOps engineer with 4yrs experience working with AWS/GCP, Kubernettes, Ansible, and other automation and web scripting tools.",
                "expiryDate" => "07/08/2019",
                "salary" => "8.5 - 15Million p/a",
                "additionalCompetencies" => "GCP/AZURE. At least 2 out of Python, Golang, Ruby and Java ",
                "guideline" => "n/a",
                "published" => true,
                "responsibilities" => "Ensure 99.99% up-time of all our apps",
                "experience" => "4years experience in working in a devOps capacity",
                "location" => "Lagos",
                "description" => "this is a sample description",
                "jobType_id" => "1",
                "spec_id" => "2",
                'updated_at' => $now,
                'created_at' => $now,
                'user_id' => 11
            ]

        ]);
    }
}
