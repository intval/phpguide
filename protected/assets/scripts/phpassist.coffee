(($) ->
  $.fn.phpassist = ->

    user = 'intval'
    key = 'fb42b812b22c9d26debfb2ddc5bb1e79'
    url = '//phpassist.com/Api/Assist'

    STATUS_ERROR = "error"
    STATUS_SUCCESS = "success"


    @each ->

      code = $(this).text()
      data = {"user": user, "key": key, "code": code}

      callback = (response) ->
        if response.status == STATUS_ERROR
          console.log 'error', response
        else
          console.log 'success', response

      $.post url, data, callback, 'JSON'

)(jQuery)


jQuery(document).ready ->
  jQuery('div.codeblock').phpassist()