function throttle(fn, threshold, scope) {
  threshold = threshold || 250;
  var last,
      deferTimer;
  return function () {
    var context = scope || this;

    var now = +new Date(),
        args = arguments;
    if (last && now < last + threshold) {
      // hold on to it
      clearTimeout(deferTimer);
      deferTimer = setTimeout(function () {
        last = now;
        fn.apply(context, args);
      }, threshold);
    } else {
      last = now;
      fn.apply(context, args);
    }
  };
};

function replaceContent( selector, newContent ) {
  var $element = document.querySelector( selector ),
      $wrapper = document.createElement( 'html' ),
      $elementResponse;
  
  $wrapper.innerHTML = newContent;
  $elementResponse = $wrapper.querySelector( selector );

  if ( null !== $element && null !== $elementResponse ) {
    $element.innerHTML = $elementResponse.innerHTML;
    document.querySelector( 'body' ).setAttribute( 'class', $wrapper.querySelector( 'body' ).getAttribute( 'class' ) );
  }

  document.dispatchEvent( new Event('DOMContentReplaced') );
}

/**
 * Send off an AJAX request to get new content.
 * @param  string requestURL The URL to get content.
 * @return XMLHttpRequest
 */
function ajax( requestURL ) {
  var xhr = new XMLHttpRequest();

  xhr.open( 'GET', requestURL );
  xhr.onreadystatechange = function() {
    if ( 4 == xhr.readyState && 200 == xhr.status ) {
      
      // Good response, parse for main content and return
      replaceContent( 'main', xhr.responseText );

    }
  };
  xhr.send();
  return xhr;
}
