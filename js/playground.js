/**
 * @file
 * Javascript for adding the jsPDF playground editor to the
 * add/edit entity form.
 */
(function ($, Drupal, drupalSettings) {

  'use strict';

   /**
   * Attaches the Charts example JS behavior.
   */
  Drupal.behaviors.chartsExampleToPdf = {
    attach: function (context, settings) {

      $('#charts-example-convert-to-pdf', context).once('chartsExampleToPdf').click(function () {

        // Example 1. Just download the file.
        html2pdf(document.body);

        // Example 2. Save the file on server with set PDF parameters.
        let element = document.body;
        let opt = {
          margin:       1,
          filename:     'chart-'+$.now()+'.pdf',
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2 },
          jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf()
          .set(opt)
          .from(element)
          .toPdf()
          .output('datauristring')
          .then(function (pdfAsString) {
            $.post('/charts-example/chart/pdf', {
                data: pdfAsString
              },
              function (response, status) {
                console.log(status);
              })
              .done(function(data, status) {
                console.log('done ' + status);
              })
              .fail(function(data, status) {
                console.log('fail ' + status);
              });

        });

      });
    }
  };
})(jQuery, Drupal, drupalSettings);
