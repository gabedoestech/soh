function HTMLtoPDF(){
var pdf = new jsPDF('l', 'pt', 'letter');
source = $('#HTMLtoPDF')[0];
specialElementHandlers = {
	'#bypassme': function(element, renderer){
		return true
	}
}
margins = {
    top: 15,
    left: 100,
    width: 545
  };

var numberOfPages = pdf.internal.getNumberOfPages();

//numberOfPages = 26;

// Set properties on the document
pdf.setProperties({
	title: 'Seal of Health Medical History',
	subject: 'Medical History',		
	author: 'Software Seals',

});

pdf.setTextColor(0,0,0);

pdf.fromHTML(
  	source // HTML string or DOM elem ref.
  	, margins.left // x coord
  	, margins.top // y coord
  	, {
  		'width': margins.width // max width of content on PDF
  		, 'elementHandlers': specialElementHandlers
  	},
  	function (dispose) {
  	  // dispose: object with X, Y of the last line add to the PDF
  	  //          this allow the insertion of new lines after html
				if(numberOfPages > 25)
				{
					alert("Medical history is too large. Our policy does not allow users to download files size exceeds 1 GB.");
					return;
				}
				else
				{
					  pdf.save('SealofHealthMedicalRecord.pdf');
				}
      }
  )		
}