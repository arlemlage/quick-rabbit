<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Forum Routes
    |--------------------------------------------------------------------------
    |
    | Here you can specify the specific routes for the different sections of
    | your forum.
    |
    */

    'routes' => [
        'home'       => 'ticketly-forums',
        'discussion' => 'discussion',
        'category'   => 'category',
        'post'       => 'posts',
        'register'   => 'register',
        'login'      => 'login',
    ],

    /*
    |--------------------------------------------------------------------------
    | Forum Titles
    |--------------------------------------------------------------------------
    |
    | These are some default titles (words) that will be used throughout your
    | forum. You can change these to whatever you would like :)
    |
    */

    'titles' => [
        'discussion'  => 'Discussion',
        'discussions' => 'Discussions',
        'category'    => 'Type',
    ],

   /*
    |--------------------------------------------------------------------------
    | The main headline and description of your forum
    |--------------------------------------------------------------------------
    |
    | Your headline and your description will be shown on the homepage of your
    | forum, unless you change the default theme.
    |
    |   *headline*: This is the main headline on the forum homepage
    |
    |   *description*: This is the main description that will show under the
    |       headline on the forum homepage.
    |   *headline_logo*: If this is set an image will be used on the forum home
    |       instead of text. Specify the relative path to the image here.
    |
    */

    'headline'      => 'Welcome to Ticketly Forum',
    //'description'   => 'A simple forum.',
    //'headline_logo' => 'public/vendor/devdojo/chatter/assets/images/logo-light.jpg',

    /*
    |--------------------------------------------------------------------------
    | Header and Footer Yield Inserts for your master file
    |--------------------------------------------------------------------------
    |
    | Chatter needs to add css or javascript to the header and footer of your
    | master layout file. You can choose what these will be called. FYI,
    | chatter will only load resources when you hit a forum route.
    |
    | example:
    | Inside of your <head></head> tag of your master file, you'll need to
    | include @yield('css').
    |
    | Next, before the ending body </body>, you will need to include the footer
    | yeild like so @yield('js')
    |
    */

    'yields' => [
        'head'   => 'css',
        'footer' => 'js',
    ],

    /*
    |--------------------------------------------------------------------------
    | The master layout file for your site
    |--------------------------------------------------------------------------
    |
    | By default laravels master file is the layouts.app file, but if your
    | master layout file is somewhere else, you can specify it below
    |
    */

    'master_file_extend' => 'ticketly-forum.app',

    /*
    |--------------------------------------------------------------------------
    | Information about the forum User
    |--------------------------------------------------------------------------
    |
    | Your forum needs to know specific information about your user in order
    | to confirm that they are logged in and to link to their profile.
    |
    |   *namespace*: This is the user namespace for your User Model.
    |
    |   *database_field_with_user_name*: This is the database field that
    |       is used for the users 'Name', could be 'username', 'first_name'.
    |       This will appear next to the users avatar in disucssions
    |
    |   *relative_url_to_profile*: Users may want to click on another users
    |       image to view their profile. If a users profile page is at
    |       /profile/{username} you will add '/profile/{username}' or
    |       if it is /profile/{id}, you will specify '/profile/{id}'. You are
    |       only able to specify 1 url parameter.
    |       Tip: leave this blank and no link will be generated
    |
    |   *relative_url_to_image_assets*: This is where your image assets are
    |       located. This will be used with the 'avatar_image_database_field'
    |       so if your image assets are located at '/uploads/images/' and
    |       the 'avatar_image_database_field' contains 'avatars/johndoe.jpg'
    |       the full image url will be '/uploads/images/avatar/johndoe.jpg'
    |       Tip: leave this blank if you have absolute url's for images
    |       stored in the database.
    |
    |   *avatar_image_database_field*: This is the database field that
    |       contains the logged in user avatar image. This field will
    |       be inside of the 'users' database table. Tip: leave this
    |       empty if you want to keep the default color circles with
    |       users first initial.
    |
    */

    'user' => [
        'namespace'                     => 'App\Model\User',
        'database_field_with_user_name' => 'name',
        'relative_url_to_profile'       => '',
        'relative_url_to_image_assets'  => '',
        'avatar_image_database_field'   => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Alert Message Titles
    |--------------------------------------------------------------------------
    |
    | When a user successfully adds a new discussion or they do something wrong
    | they will get an alert message. Based on the alert message there is a
    | specific title message for every alert, which are defined below.
    |
    */

    'alert_messages' => [
        'success' => 'Well done!',
        'info'    => 'Heads Up!',
        'warning' => 'Wuh Oh!',
        'danger'  => 'Error!',
    ],

    /*
    |--------------------------------------------------------------------------
    | A Few security measures to prevent spam on your forum
    |--------------------------------------------------------------------------
    |
    | Here are a few configurations that you can add to your forum to prevent
    | possible spammers or bots.
    |
    |   *limit_time_between_posts*: Stop user from being able to spam by making
    |       them wait a specified time before being able to post again.
    |
    |   *time_between_posts*: In minutes, the time a user must wait before
    |       being allowed to add more content. Only valid if above value is
    |       set to true.
    |
    */

    'security' => [
        'limit_time_between_posts' => false, //
        'time_between_posts'       => 1, // In minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatter Editor
    |--------------------------------------------------------------------------
    |
    | You may wish to choose between a couple different editors. At the moment
    | The following editors are supported:
    |   - tinymce    (https://www.tinymce.com/)
    |   - simplemde  (https://simplemde.com/)
    |
    */

    'editor' => 'tinymce',

    /*
    |--------------------------------------------------------------------------
    | TinyMCE WYSIWYG Editor Options (Must be the selected editor)
    |--------------------------------------------------------------------------
    |
    | Select which tools you want to appear in the tinymce editor toolbar.
    | Find out the available tools here:
    | tinymce.com/docs/advanced/editor-control-identifiers/#toolbarcontrols
    |
    |   *toolbar*: The controls you want to appear in the toolbar
    |
    |   *plugins*: Sometimes in order to add a control to the toolbar you may
    |       need to specify to include the plugin for the control. You can
    |       learn more about this in the link above. If it is part of the
    |       'core' you do not need to include a plugin in order to use it
    |       in the toolbar.
    |
    */

    'tinymce' => [
        'toolbar' => 'bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
        'plugins' => 'link, image',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Settings
    |--------------------------------------------------------------------------
    |
    | The following are settings that you can use to modify the email settings
    |   - enabled (if you would like to enable or disable email notifications)
    |   - view (the email view sent) $discussion var is passed to view
    |   -
    |
    */

    'email' => [
        'enabled' => false,
        'view'    => 'chatter::email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | These are the pagination settings for your forum. Specify how many number
    | of results you want to show per page.
    |
    */

    'paginate' => [
        'num_of_results' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | Configure the middleware applied to specific routes across Chatter. This
    | gives you full control over middleware throughout your application. You
    | can allow public access to everything or limit to specific routes.
    |
    | Authentication is enforced on create, store, edit, update, destroy routes,
    | no need to add 'auth' to these routes.
    |
    */

    'middleware' => [
        'global'     => ['web', 'auth'],
        'home'       => [],
        'discussion' => [
            'index'   => [],
            'show'    => [],
            'create'  => [],
            'store'   => [],
            'destroy' => [],
            'edit'    => [],
            'update'  => [],
        ],
        'post' => [
            'index'   => [],
            'show'    => [],
            'create'  => [],
            'store'   => [],
            'destroy' => [],
            'edit'    => [],
            'update'  => [],
        ],
        'category' => [
            'show' => [],
        ],
    ],
];
