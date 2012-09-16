$(document).ready(function() {
	 $(".correct_ans").click(function() {
		  aid = $(this).attr('ref');
		  $(this).addClass('disabled');
		  $.get("/qna/markascorrect/", { ans: aid } );
		  $(this).text('תודה לך!');

		  $('.correct_ans[ref!="'+ aid +'"]').remove();
		  return false;
		});
}	