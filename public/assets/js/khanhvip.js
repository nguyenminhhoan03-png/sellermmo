$(document).ready(function() {
    function generateRandomClass(length) {
      return Array.from({ length }, () => '\\x' + Math.floor(16 * Math.random()).toString(16) + Math.floor(16 * Math.random()).toString(16)).join('');
    }

    function applyRandomClassToElements(selector, className) {
      $(selector).each(function() {
        $(this).addClass(className);
      });
    }

    const randomClass = generateRandomClass(20);
    applyRandomClassToElements('*', randomClass);
  });