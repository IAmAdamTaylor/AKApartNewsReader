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

function replaceMainContent( newContent ) {
  var $main = document.querySelector( 'main' ),
      $wrapper = document.createElement( 'div' ),
      $mainResponse;
  
  $wrapper.innerHTML = newContent;
  $mainResponse = $wrapper.querySelector( 'main' );

  if ( null !== $main && null !== $mainResponse ) {
    $main.innerHTML = $mainResponse.innerHTML;
  }

  document.dispatchEvent( new Event('mainContentReplaced') );
};

function ajax( requestURL ) {
  var xhr = new XMLHttpRequest();

  xhr.open( 'GET', requestURL );
  xhr.onreadystatechange = function() {
    if ( 4 == xhr.readyState && 200 == xhr.status ) {
      
      // Good response, parse for main content and return
      replaceMainContent( xhr.responseText );

    }
  };
  xhr.send();
}
