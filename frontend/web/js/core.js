"use strict";
console.log('Core View object loaded');



const View = {
  /**
   * Tag selector to insert template
   * @param selector
   * html template id
   * @param templateId
   * vars for insert in html
   * @param data
   */
  render(selector, templateId, data) {
    $(selector).append(this.renderTemplate(templateId, data));

  },
  /**
   * html template id
   * @param templateId
   * data to insert in html template
   * @param data
   * return html
   * @return string
   */
  renderTemplate(templateId, data) {
    // convert DocumentFragment to string
    var source = Array.prototype.reduce.call(document.getElementById(templateId).content.childNodes, function(html, node) {
      return html + ( node.outerHTML || node.nodeValue );
    }, "");

    var template = Handlebars.compile(source);

    var html = template(data);

    return html;
  }
};

//View.render('#test-tamplate', 'journal-tpl', {title: "My New Post", body: "This is my first post!"});