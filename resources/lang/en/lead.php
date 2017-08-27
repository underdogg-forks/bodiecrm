<?php
return [
    /**
     * General information
     */
    'time_to_conversion' => 'How long it took this lead to convert after their first visit',
    'attribution_label' => 'General attribution data for this lead',
    'owner' => 'This user can manage this lead',
    'follower' => 'This user is following',
    'original_visit' => 'When the user first visited the website',
    'converting_visit' => 'When the user visited the website during conversion',
    'submitted_lead' => 'When the user actually submitted the form',
    'landing_page' => 'Select the landing page that this lead belongs to',
    /**
     * Leads information
     */
    'lead_created' => 'Created lead for landing page: :landing_page',
    'added_users' => 'Assigned lead to users: :users',
    'updated_users' => 'Updated users',
    'progress' => 'This lead\'s current stage. The stages are: unqualified lead, qualified lead, opportunity, closed',
    'updated_lead' => 'Lead updated',
    /**
     * Destroy lead
     */
    'destroy' => [
        'successful' => 'Successfully deleted lead: :fullname',
        'unsuccessful' => 'Error deleting lead: :fullname'
    ],
    /**
     * Email messages
     */
    'email' => [
        'new_lead' => 'A new lead has been submitted for :title',
        'assigned_lead' => 'A lead has been assigned to you',
    ],
];
?>