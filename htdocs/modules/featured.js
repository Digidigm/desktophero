define(['vendor/knockoutjs/knockout-3.2.0'], function (ko) {
    'use strict';
    function module(params) {
    	this.figure = params.data;

        this.figure_data = { alpha: "number", person: this.figure };
        
    }
    return { viewModel: module, template: {require: "text!modules/featured.html"} };
});
