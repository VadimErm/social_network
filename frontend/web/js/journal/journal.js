(function (window, $) {
  "use strict";

  console.log('Journal object loaded');

  const JournalController = {
    submitEvent(e) {
      console.log('Submit');

      e.preventDefault();
    },
    addEvent() {

    },
    removeEvent() {

    }
  };

  const Journal = {
    add() {

    },
    remove() {

    }
  };

  // attach journal events
  $('#journal-submit-btn').on('click', JournalController.submitEvent);

})(window, jQuery);