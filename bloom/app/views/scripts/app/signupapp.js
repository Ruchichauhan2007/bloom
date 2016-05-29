'use strict';

angular.module('starter', ['starter.controllers','ngRoute','ionic'])
.config(function ($routeProvider, $httpProvider) { // set route of html pages
        $routeProvider.when('/initial', {templateUrl: '/gladstone/portal/bloom/app/views/signup/initial.html', controller: 'initialCtrl'});
        $routeProvider.when('/havingTrouble', {templateUrl: '/gladstone/portal/bloom/app/views/signup/having_trouble.html', controller: 'havingTroubleCtrl'});
        $routeProvider.when('/shippingAddress', {templateUrl: '/gladstone/portal/bloom/app/views/signup/shippingAddress.html', controller: 'shippingAddressCtrl'});
        $routeProvider.when('/prescription', {templateUrl: '/gladstone/portal/bloom/app/views/signup/prescription.html', controller: 'prescriptionCtrl'});
        $routeProvider.when('/eligibility', {templateUrl: '/gladstone/portal/bloom/app/views/signup/eligibility.html', controller: 'eligibilityCtrl'});
        $routeProvider.when('/instructions', {templateUrl: '/gladstone/portal/bloom/app/views/signup/instructions.html', controller: 'instructionsCtrl'});
        $routeProvider.when('/confirmation', {templateUrl: '/gladstone/portal/bloom/app/views/signup/confirmation.html', controller: 'confirmationCtrl'});
        $routeProvider.when('/confirmed', {templateUrl: '/gladstone/portal/bloom/app/views/signup/confirmed.html', controller: 'confirmedCtrl'});
        $routeProvider.when('/privacyPolicy', {templateUrl: '/gladstone/portal/bloom/app/views/signup/privacyPolicy.html', controller: 'privacyPolicyCtrl'});
        $routeProvider.when('/termsService', {templateUrl: '/gladstone/portal/bloom/app/views/signup/termsService.html', controller: 'termsServiceCtrl'});
        $routeProvider.otherwise({redirectTo: '/initial'}); // defult route

        /* CORS... */
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        });



