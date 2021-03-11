require('./bootstrap');
import 'bootstrap';
import initAnswerOptions from './vote/create';
import $ from 'jquery';

$(function () {
    initAnswerOptions();
});
