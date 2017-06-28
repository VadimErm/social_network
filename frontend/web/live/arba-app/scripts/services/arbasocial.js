'use strict';

/**
 * @ngdoc service
 * @name arbaLiveApp.ArbaSocial
 * @description
 * # ArbaSocial
 * Factory in the arbaLiveApp.
 */
angular.module('arbaLiveApp')
  .factory('ArbaSocial', function () {
    // Service logic
    // ...

    var meaningOfLife = 42;

    // Public API here
    return {
      someMethod: function () {
        return meaningOfLife;
      }
    };
  });
