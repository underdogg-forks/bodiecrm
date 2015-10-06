@extends('layouts.home')





@section('title')
    Leads - Create
@stop





@section('subtitle')
    Manually create a lead
@stop





@section('breadcrumb')
    <li><a href = "{{ url('leads') }}">All Leads</a></li>
    <li class = "active"><a href = "{{ url('leads/create') }}">Create Lead</a></li>
@stop





@section('dates')

@stop



@section('links')

@stop





@include('partials.header')








@section('content')

    <div id = "leads_single_create" class = "row">
        @if ( ! $user->landing_pages_active()->isEmpty() )
            <div class = "small-12 columns" data-equalizer>
                <p>Manually create a new lead and associate it to a landing page.</p>

                <form method = "POST" action = "{{ url('leads/create') }}" class = "row" data-abide>

                    {!! csrf_field() !!}

                    <input type = "hidden" name = "_redirect" value = "false" />

                    <div class = "small-12 columns">
                        <label for = "landing_page">
                            <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('lead.landing_page') }}">Landing Page <i class = "fa fa-question-circle"></i>
                                <span class = "label right">Required</span>
                        </label>
                        <select id = "landing_page_select" name = "landing_page_id" data-url = "{{ url('landing_pages/get_auth_key') }}" data-csrf = "{!! csrf_token() !!}" required>
                            <option value = "">Select One</option>
                            @foreach ( $user->landing_pages_active() as $landing_page )
                            <option value = "{{ $landing_page->id }}" data-key = "{{ $landing_page->auth_key }}">{{ $landing_page->title }}</option>
                            @endforeach
                        </select>
                        <small class = "error">Landing page is required</small>

                        <input type = "hidden" id = "auth_key" name = "auth_key" value = "" />
                    </div>

                    <div id = "leads_single_create_defaults" class = "small-6 columns">

                        <div class = "small-12 columns">
                            <label for = "first_name">First name</label>
                            <input type = "text" name = "first_name" pattern = 'alpha' placeholder = "John" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "last_name">Last name</label>
                            <input type = "text" name = "last_name" pattern = 'alpha' placeholder = "Doe" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "email">Email</label>
                            <input type = "email" name = "email" placeholder = "email@email.com" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "company">Company</label>
                            <input type = "text" name = "company" placeholder = "Acme Company" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "title">Title</label>
                            <input type = "text" name = "title" placeholder = "CEO" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "phone">Phone</label>
                            <input type = "text" name = "phone" placeholder = "(123) 456-7890" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "address">Address</label>
                            <textarea name = "address" placeholder = "345 Spear Street, Floor 4"></textarea>
                        </div>

                        <div class = "small-12 columns">
                            <label for = "city">City</label>
                            <input type = "text" name = "city" placeholder = "San Francisco" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "state">State</label>
                            <input type = "text" name = "state" placeholder = "CA" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "zip">Zip code</label>
                            <input type = "text" name = "zip" pattern = 'number' placeholder = "94102" />
                        </div>

                        <div class = "small-12 columns">
                            <label for = "country">Country</label>
                            <input type = "text" name = "country" placeholder = "USA" />
                        </div>
                    </div>

                    <div id = "leads_single_create_custom" class = "small-6 columns">
                        <a class = "button small-12 small columns">Add a custom field</a>
                    </div>

                    <div class = "small-12 columns">
                        <input type = "submit" value = "Create Lead" class = "button large radius small-4 columns" />
                    </div>
                </form>





                <div id = "custom_fields" class = "custom_field_container small-12 columns hide">
                    <div class = "small-6 columns">
                        <label>What is this field called?</label>
                        <input type = "text" class = "custom_field_name" placeholder = "Key" />
                    </div>
                    <div class = "small-6 columns">
                        <label>Field value</label>
                        <input type = "text" class = "custom_field_value" name = "" value = "" placeholder = "Value" />
                    </div>
                </div>
            </div>
        @else
            <div id = "leads_single_create_empty" class = "text-center">
                <h3>You have no active landing pages to create a lead!<br>Create one in a <a href = "{{ url('campaigns') }}">Campaign</a> or ask an admin to add you.</h3>
            </div>
        @endif
    </div>

@stop