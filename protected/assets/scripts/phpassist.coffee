(($) ->
  $.fn.phpassist = ->

    user = 'intval'
    key = 'fb42b812b22c9d26debfb2ddc5bb1e79'
    url = '//phpassist.com/Api/Assist'

    STATUS_ERROR = "error"
    STATUS_SUCCESS = "ok"


    @each ->

      codeElem = $ this
      code = codeElem.text()
      data = {"user": user, "key": key, "code": code}

      callback = (response) ->
        if response.status == STATUS_ERROR
          console.log 'aiai, phpassist is browken!!!'
        else if response.status == STATUS_SUCCESS
          iframeCode = decodeURIComponent response.url.replace /\+/g, ' '
          codeElem.replaceWith iframeCode
        else
          console.log 'kurwa! unknow phpassist status'

      $.post url, data, callback, 'JSON'

)(jQuery)


jQuery(document).ready ->
  jQuery('div.codeblock').phpassist()