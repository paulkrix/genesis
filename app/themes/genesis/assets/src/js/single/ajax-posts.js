/**
  * @desc This is an example ajax script
  * @required jQuery
  */

var GenesisAjaxPosts = function( $ ) {
  var ajaxurl = posts_object.ajaxurl;
  var action = posts_object.action;
  var nonce = posts_object._ajax_nonce;
  var loading = false;
  var $resultTarget = null;
  var page = 1;

  $(document).ready( function() {

    $resultTarget = jQuery('#posts-container');
    initPagination();

  });

  function initPagination() {
    var $pagination = $resultTarget.find('.pagination');
    var $prev = $pagination.find('.prev').first();
    var $next = $pagination.find('.next').first();
    var $pageNumbers = $pagination.find('a.page-numbers');

    $next.click( function( evt ) {
      evt.stopPropagation();
      page++;
      load();
      return false;
    });

    $prev.click( function( evt ) {
      evt.stopPropagation();
      page--;
      load();
      return false;
    });

    $pageNumbers.click( function( evt ) {
      evt.preventDefault();
      page = $(evt.target).attr('data-target');
      load();
      return false;
    });

  }

  function load() {
    if( loading ) {
      return false;
    }
    var queryArgs = {
        action: action,
        _ajax_nonce: nonce,
        paged: page
    };
    startLoading();
    jQuery.get( ajaxurl,  queryArgs,
      function( response ) {
        $resultTarget.html( response.data.html );
        stopLoading();
    });
  }

  function startLoading( ) {
    $resultTarget.addClass('loading');
    loading = true;
  }
  function stopLoading( ) {
    $resultTarget.removeClass('loading');
    initPagination();
    loading = false;
  }
} ( jQuery )
