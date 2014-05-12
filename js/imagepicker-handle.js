// JavaScript Document

$( document ).ready(function() {

if($("select#icon").length > 0 ) {
$("select#icon").imagepicker();
}

if($("select#page_image").length > 0) {
	$("select#page_image").imagepicker();
}

if($("select#default_icon").length > 0) {
	$("select#default_icon").imagepicker();
}
});