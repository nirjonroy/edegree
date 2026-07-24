<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\ContactPage;
use Illuminate\Database\Seeder;

class AboutContactPageSeeder extends Seeder
{
    public function run(): void
    {
        About::updateOrCreate(
            ['page_title' => 'About eDegree+'],
            [
                'profile_title' => 'Our Institutional Profile',
                'about_us' => '<p>eDegree+ is a premium online education marketplace built strictly around university-degree options. We select and compile accredited distance-learning curricula, mapping online MBA, DBA, Master\'s, and Bachelor\'s programs from top partner institutions worldwide.</p><p>Our mission is simple: to help working professionals identify recognized academic programs, compare syllabus requirements, and submit applications directly to universities without career disruption.</p>',
                'stat_1_value' => '50+',
                'stat_1_label' => 'Accredited Partners',
                'stat_2_value' => '100%',
                'stat_2_label' => 'Online Formats',
                'stat_3_value' => '24-Hr',
                'stat_3_label' => 'Advisor Response',
                'faq_title' => 'Frequently Asked Questions',
                'faq_question_1' => 'Are these degrees identical to traditional campus awards?',
                'faq_answer_1' => 'Yes. Our partner universities award standard degree credentials that carry identical accreditation status, modules, rights, and transcript structures to campus-based programs.',
                'faq_question_2' => 'How does early scholarship allocation function?',
                'faq_answer_2' => 'Students submitting queries via eDegree+ counseling widgets are paired with advisors who check current early cohort scholarship pools and partner discounts.',
                'faq_question_3' => 'Who determines program eligibility guidelines?',
                'faq_answer_3' => 'Admissions criteria, transfer credit audits, work experience weights, and final enrollment clearances are evaluated by each partner university.',
                'meta_title' => 'About eDegree+',
                'meta_description' => 'Learn about eDegree+ and how we help professionals compare accredited online university degree programs.',
                'status' => true,
            ]
        );

        ContactPage::updateOrCreate(
            ['page_title' => 'Contact eDegree+'],
            [
                'subtitle' => 'Get in touch with our team for student counseling support, university listing requests, or advertising inquiries.',
                'details_title' => 'Connect Directly',
                'email_label' => 'Email Inquiry',
                'email' => 'support@edegreeplus.com',
                'phone_label' => 'Support Hotlines',
                'phone_1' => '+1 (800) 555-DEGREE',
                'phone_2' => '+44 (0) 20 7946 0958',
                'office_label' => 'Corporate Offices',
                'office_1' => '100 Pine Street, San Francisco, CA 94111',
                'office_2' => '168 Clifton St, London EC2A 4DP, UK',
                'form_title' => 'Send a Message',
                'name_placeholder' => 'John Doe',
                'email_placeholder' => 'john.doe@company.com',
                'subject_placeholder' => 'Listing assistance / Student support',
                'message_placeholder' => 'Describe your question in detail...',
                'button_text' => 'Submit Message',
                'success_title' => 'Message Sent Successfully!',
                'success_message' => 'We have received your message and support teams will reply within 24 hours.',
                'meta_title' => 'Contact eDegree+',
                'meta_description' => 'Contact eDegree+ for student counseling support, university listing requests, and advertising inquiries.',
                'status' => true,
            ]
        );
    }
}
