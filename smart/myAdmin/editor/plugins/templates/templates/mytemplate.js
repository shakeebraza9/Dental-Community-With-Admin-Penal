// Register a template definition set named "default".
CKEDITOR.addTemplates( 'default',
{
	// The name of the subfolder that holds the preview images of the templates.
	imagesPath : CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The template definitions.
	templates :
		[
			{
				title: 'Nutritional Facts',
				image: '',
				description: 'Nutritional facts template with some sample data.',
				html:
					'<div class="facts_section">' + 
        
        '<h2> Nutritional Facts (Typical Values) </h2>' +
        '<h3> Serving Size 1/4 cup dry (45g)  </h3>' +
        '<h3> (makes 3/4 cup prepared) </h3>' +
        '<h4> Amount per Serving </h4>' +
        '<table>' +
          
          '<tr>' +
          '<td> <span> Calories 164 </span> </td>' +
          '<td class="for_right"> Calories from Fat 2  </td>' +
          '</tr>' +

          '<tr>' +
          '<td> </td>' +
          '<td class="for_right"> % Daily Value </td>' +
          '</tr>' +

          '<tr>' +
          '<td><span> Total Fat </span> 0g </td>' +
          '<td class="for_right"> 0% </td>' +
          '</tr>' +

          '<tr>'+
          '<td> Saturated Fat 0g </td>'+
          '<td class="for_right"> 0% </td>'+
          '</tr> '+

          '<tr>'+
          '<td> Trans Fat 0g </td>'+
          '<td class="for_right"> 0% </td>'+
          '</tr> '+

          '<tr>'+
          '<td><span> Cholestrol </span> 0mg </td>'+
          '<td class="for_right"> 0% </td>'+
          '</tr>' + 

          '<tr>'+
          '<td> <span> Sodium </span> 2mg </td>'+
          '<td class="for_right"> 0% </td>'+
          '</tr>'+

          '<tr>'+
          '<td> <span> Total Carbohydarate 36g </span></td>'+
          '<td class="for_right"> 12% </td>'+
          '</tr>'+

          '<tr>'+
          '<td> Dietary Fiber 1g </td>'+
          '<td class="for_right"> 2% </td>'+
          '</tr>'+

          '<tr>'+
          '<td> Sugar 0g </td>'+
          '<td> </td>'+
          '</tr>'+

          '<tr>'+
          '<td> <span> Protein </span> 3g </td>'+
          '<td class="for_right"> 6% </td>'+
          '</tr>'+

        '</table>'+

        '<table class="table_box">'+
          
          '<tr>'+
          '<td> <span> Vitamin A </span> </td>'+
          '<td> 0% Vitamin C</td>'+
          '<td class="for_right"> 0% </td>'+
          '</tr>'+

          '<tr>'+
          '<td> <span> Calcium </span> </td>'+
          '<td> 1% Iron </td>'+
          '<td class="for_right"> 2% </td>'+
          '</tr>'+

        '</table>'+

        '<p> Percent Daily values (DV) are based on a 2,000 calories diet. Your daily values '+ 
        'may be higher or lower depending on your calorie needs:</p>'+

      '</div>'
			},{
				title: 'Image and Title',
				image: 'template1.gif',
				description: 'One main image with a title and text that surround the image.',
				html:
					'<h3>' +
						'<img style="margin-right: 10px" height="100" width="100" align="left"/>' +
						'Type the title here'+
					'</h3>' +
					'<p>' +
						'Type the text here' +
					'</p>'
			},
			{
				title: 'Strange Template',
				image: 'template2.gif',
				description: 'A template that defines two colums, each one with a title, and some text.',
				html:
					'<table cellspacing="0" cellpadding="0" style="width:100%" border="0">' +
						'<tr>' +
							'<td style="width:50%">' +
								'<h3>Title 1</h3>' +
							'</td>' +
							'<td></td>' +
							'<td style="width:50%">' +
								'<h3>Title 2</h3>' +
							'</td>' +
						'</tr>' +
						'<tr>' +
							'<td>' +
								'Text 1' +
							'</td>' +
							'<td></td>' +
							'<td>' +
								'Text 2' +
							'</td>' +
						'</tr>' +
					'</table>' +
					'<p>' +
						'More text goes here.' +
					'</p>'
			},
			{
				title: 'Text and Table',
				image: 'template3.gif',
				description: 'A title with some text and a table.',
				html:
					'<div style="width: 80%">' +
						'<h3>' +
							'Title goes here' +
						'</h3>' +
						'<table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1">' +
							'<caption style="border:solid 1px black">' +
								'<strong>Table title</strong>' +
							'</caption>' +
							'</tr>' +
							'<tr>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
							'</tr>' +
							'<tr>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
							'</tr>' +
							'<tr>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
								'<td>&nbsp;</td>' +
							'</tr>' +
						'</table>' +
						'<p>' +
							'Type the text here' +
						'</p>' +
					'</div>'
			}

			,{
				title: 'My Template 1',
				image: 'template1.gif',
				description: 'Description of My Template 1.',
				html:
					'<h2>Template 1</h2>' +
					'<p><img src="/logo.png" style="float:left" />Type your text here.</p>'
			},
			{
				title: 'My Template 2',
				html:
					'<h3>Template 2</h3>' +
					'<p>Type your text here.</p>'
			},{
				title: 'My Template 1',
				image: 'template1.gif',
				description: 'Description of My Template 1.',
				html:
					'<h2>Template 1</h2>' +
					'<p><img src="/logo.png" style="float:left" />Type your text here.</p>'
			},
			{
				title: 'My Template 2',
				html:
					'<h3>Template 2</h3>' +
					'<p>Type your text here.</p>'
			},{
				title: 'My Template 1',
				image: 'template1.gif',
				description: 'Description of My Template 1.',
				html:
					'<h2>Template 1</h2>' +
					'<p><img src="/logo.png" style="float:left" />Type your text here.</p>'
			},
			{
				title: 'My Template 2',
				html:
					'<h3>Template 2</h3>' +
					'<p>Type your text here.</p>'
			}
			
		]
});