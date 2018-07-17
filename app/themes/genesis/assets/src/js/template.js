/**
  * @desc This is an example JS module for pre ES6
  * Code within the module can use $ for jQuery even if jQuery is in
  * no conflict mode.
  * Outside of the module you can use public methods from the modules like this:
  *   ModuleName.publicMethod();
  * @required jQuery
  */

var ModuleName = (function ( $ ) {

  //Private methods
  var _privateMethod = function () {
    //Do stuff
  };

  //Public methods - see the return command below
  var publicMethod = function () {
    _privateMethod();
  };

  //Anything you want to be public must also be included here
  return {
    publicMethod: publicMethod
  };

})( jQuery );
