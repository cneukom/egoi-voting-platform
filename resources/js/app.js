import initCloseVote from "./vote/close";

require('./bootstrap');
import 'bootstrap';
import initAnswerOptions from './vote/create';
import $ from 'jquery';

$(function () {
    initAnswerOptions();
    initCloseVote();
});
