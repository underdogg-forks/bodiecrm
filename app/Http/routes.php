<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('public/index');
}); 





// Authentication routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');






// Lead submission routes
Route::group(['middleware' => 'spam'], function() {
    Route::post('submit', 'LeadController@store');
    Route::get('pixel', 'AttributionController@store');
});







/**
 * Ajax-only routes
 */
Route::group(['middleware' => ['auth', 'ajax']], function() {
    Route::get('data/all_leads', 'DataTablesController@getAllLeads');
    Route::get('data/owner_leads', 'DataTablesController@getOwnerLeads');
    Route::get('data/watcher_leads', 'DataTablesController@getWatcherLeads');



    Route::get('leads/{leads}/watch', 'LeadController@getWatchLead');
    Route::get('leads/{leads}/unwatch', 'LeadController@getUnwatchLead');



    Route::post('campaigns/{campaigns}/add_comment', 'CampaignController@postAddComment');
    Route::post('landing_pages/{landing_pages}/add_comment', 'LandingPageController@postAddComment');
    Route::post('leads/{leads}/add_comment', 'LeadController@postAddComment');
});







// Authenticated routes
Route::group(['middleware' => 'auth'], function() {


    Route::get('campaigns/archived', 'CampaignController@getIndexArchived');
    Route::get('campaigns/{campaigns}/add_users', 'CampaignController@getAddUsers');
    Route::put('campaigns/{campaigns}/add_users', 'CampaignController@putAddUsers');
    Route::put('campaigns/{campaigns}/update_users', 'CampaignController@putUpdateUsers');
    Route::get('campaigns/{campaigns}/add_landing_page', 'CampaignController@getAddLandingPage');
    Route::post('campaigns/{campaigns}/add_landing_page', 'CampaignController@postAddLandingPage');
    Route::get('campaigns/{campaigns}/archive', 'CampaignController@getArchiveCampaign');
    Route::put('campaigns/{campaigns}/archive', 'CampaignController@putArchiveCampaign');
    Route::get('campaigns/{campaigns}/unarchive', 'CampaignController@getUnarchiveCampaign');
    Route::put('campaigns/{campaigns}/unarchive', 'CampaignController@putUnarchiveCampaign');
    Route::resource('campaigns', 'CampaignController');






    

    Route::get('landing_pages/archived', 'LandingPageController@getIndexArchived');
    Route::get('landing_pages/{landing_pages}/web_to_lead', 'LandingPageController@getWebToLead');
    Route::get('landing_pages/{landing_pages}/archive', 'LandingPageController@getArchiveLandingPage');
    Route::put('landing_pages/{landing_pages}/archive', 'LandingPageController@putArchiveLandingPage');
    Route::get('landing_pages/{landing_pages}/unarchive', 'LandingPageController@getUnarchiveLandingPage');
    Route::put('landing_pages/{landing_pages}/unarchive', 'LandingPageController@putUnarchiveLandingPage');
    Route::resource('landing_pages', 'LandingPageController');









    Route::get('leads/{leads}/assign_lead', 'LeadController@getAssignLead');
    Route::put('leads/{leads}/add_users', 'LeadController@putAssignLead');
    Route::put('leads/{leads}/update_users', 'LeadController@putUpdateLeadUsers');
    Route::get('leads/{leads}/delete', 'LeadController@getDestroyLead');
    Route::get('leads/owner', 'LeadController@getIndexOwner');
    Route::get('leads/watcher', 'LeadController@getIndexWatcher');
    Route::post('leads/create', 'LeadController@postStoreLead');
    Route::resource('leads', 'LeadController');







    Route::get('user/{user}/change_password', 'UserController@getUpdatePassword');
    Route::put('user/{user}/change_password', 'UserController@putUpdatePassword');
    Route::post('user/{user}/upload_avatar', 'UserController@postAvatar');
    Route::resource('user', 'UserController');
});








