<script type="text/javascript">
			    function enhanceWordBreak({doc, cell, column}) {
                    if (cell === undefined) {
                      return;
                    }
                    const hasCustomWidth = (typeof cell.styles.cellWidth === 'number');
                    if (hasCustomWidth || cell.raw == null || cell.colSpan > 1) {
                      return
                    }
                    let text;
                    if (cell.raw instanceof Node) {
                      text = cell.raw.innerText;
                    } else {
                      if (typeof cell.raw == 'object') {
                        // not implemented yet
                        // when a cell contains other cells (colSpan)
                        return;
                      } else {
                        text = '' + cell.raw;
                      }
                    }
                    // split cell string by spaces
                    const words = text.split(/\s+/);
                    // calculate longest word width
                    const maxWordUnitWidth = words.map(s => Math.floor(doc.getStringUnitWidth(s) * 100) / 100).reduce((a, b) => Math.max(a, b), 0);
                    const maxWordWidth = maxWordUnitWidth * (cell.styles.fontSize / doc.internal.scaleFactor)
                    const minWidth = cell.padding('horizontal') + maxWordWidth;
                    // update minWidth for cell & column
                    if (minWidth > cell.minWidth) {
                      cell.minWidth = minWidth;
                    }
                    if (cell.minWidth > cell.wrappedWidth) {
                      cell.wrappedWidth = cell.minWidth;
                    }
                    if (cell.minWidth > column.minWidth) {
                      column.minWidth = cell.minWidth;
                    }
                    if (column.minWidth > column.wrappedWidth) {
                      column.wrappedWidth = column.minWidth;
                    }
                  }
				function downloadDetails(){
						const { jsPDF } = window.jspdf;
						var doc = new jsPDF();
						let packageName="<?php echo $tpackage_name ?>";
						let spackageName="<?php echo explode("|",$tpackage_name)[0].'|'.(isset(explode("|",$tpackage_name)[1])?explode("|",$tpackage_name)[1]:'')  ?>";
						var splitTitle = doc.splitTextToSize(spackageName, 240);
						var splitTitle1 = doc.splitTextToSize( (splitTitle[1]?splitTitle[1]:'')+(splitTitle[2]?splitTitle[2]:''), 300);
						let no_of_passengers="No. of pax – <?php echo $quantity_adult; ?> Adults, <?php echo $quantity_child; ?> Childrens";
						var c = document.createElement('canvas');
						var img = new Image;
						img.src= "<?php echo base_url();?>"+'assets/images/My_Holiday_Logo_3.png';
						img.onload = () => {
						c.height = img.naturalHeight;
						c.width = img.naturalWidth;
						var ctx = c.getContext('2d');
						ctx.drawImage(img, 0, 0, c.width, c.height);
						var base64String = c.toDataURL();
							doc.addImage(base64String, "PNG", 165, 10,  35, 15, undefined,'FAST');
						doc.setFontSize(9);
						doc.setFont("Helvetica", "bold");
						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), 100 - (doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w / 2) , 35);
						var height=5;
						if(splitTitle1[0]){doc.text(splitTitle1[0]+(splitTitle1[1]?"":"”"),  100 - (doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"”")).w / 2), 35+height); height+=5;}
						if(splitTitle1[1]){doc.text(splitTitle1[1]+"”",  100 - (doc.getTextDimensions(splitTitle1[1]+"”").w / 2), 35+height); height+=5;}
						doc.setFont("Helvetica","normal");
						doc.text("Dear Sir/Madam,", 15, 40+height);
						doc.text("Please find requested ", 15, 48+height);
						let strlength=doc.getTextDimensions("Please find requested ").w;
						doc.setFont("Helvetica", "bold");
						doc.text("“"+splitTitle[0]+(splitTitle1[0]?"":"”"), (strlength+15) , 48+height);
						strlength+=(15+doc.getTextDimensions("“"+splitTitle[0]+(splitTitle1[0]?"":"”")).w);
						if(splitTitle1[0]){ height+=5;doc.text(splitTitle1[0]+(splitTitle1[1]?"":"” "), 15, 48+height); strlength=(15+doc.getTextDimensions(splitTitle1[0]+(splitTitle1[1]?"":"” ")).w);}
						if(splitTitle1[1]){ height+=5; doc.text(splitTitle1[1]+"”", 15, 48+height);  strlength=(15+doc.getTextDimensions(splitTitle1[1]+"”").w);}
						doc.setFont("Helvetica","normal");
						if((doc.getTextDimensions("trip details.").w + strlength)%300==0){
						    height+=5;
						}
						doc.text("trip details.", (strlength%300)+1, 48+height);
						doc.setDrawColor(0);
						doc.setFillColor(255, 255, 0);
						doc.rect(14, 53+height, doc.getTextDimensions(no_of_passengers).w+1, doc.getTextDimensions(no_of_passengers).h+1, "F");
						doc.text(no_of_passengers, 14, 56+height);
						 let result = [];
						<?php $nights=0; foreach($field_value as $index => $hotel_id)
						{
							$hotel_details = $this->Common_model->get_records("hotel_name, destination_name, room_type", "tbl_hotel", "hotel_id=$hotel_id");
							$hotel_name=$hotel_details[0]['hotel_name'];
							$room_type=$hotel_details[0]['room_type'];
							$acc_destiantion_id = $this->Common_model->showname_fromid("destination_name", "tbl_hotel", "hotel_id=$hotel_id");
							$noof_nights = $this->Common_model->showname_fromid("noof_days", "tbl_package_accomodation", "package_id=$hid_packageid and destination_id=$acc_destiantion_id");
							$destination_name = $this->Common_model->showname_fromid("destination_name", "tbl_destination", " destination_id=$acc_destiantion_id");
                                for($n=0; $n<$noof_nights; $n++)
			                    {
								$hoteldate = date("dS M", strtotime("+".($nights)." days", strtotime("$travel_date_foramt")));?>
								if(0==<?php echo $index; ?> && 0==<?php echo $nights; ?> ){
									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ,{ content: "<?php echo $vehicle_name ?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }} , { content: "<?php echo 'Rs. '. preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $total_price); ?>", rowSpan: <?php echo $rowspan; ?>, styles: { valign: 'middle' }}]);
								}else{
									result.push(["<?php echo $hoteldate ?>","<?php echo $hotel_name ?>","<?php echo $destination_name ?>","<?php echo floor(($quantity_adult +  $quantity_child)/2); ?> <?php echo $room_type ?>", "Breakfast" ]);
								}
							<?php 
							    $nights++;
			                    }
						}?>
						let yPos = 0;
						doc.autoTable({
					       theme: 'grid',    
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216],textColor: [2, 0, 0] , lineWidth: 0.25,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },     
					      pageBreak: 'avoid',	   
					      startY : 62+height,
					      head:  [["Date","Hotel", "Place","No. of rooms","Notes","Vehicle","Total Cost"]],
					      body: result,   
					      didParseCell:enhanceWordBreak,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    }
					    });
						yPos+=5;
						var tableWidth=0;
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							var timelineheadingWidth=doc.getTextDimensions(document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')).w
							tableWidth=tableWidth<timelineheadingWidth?timelineheadingWidth:tableWidth;
						}
						for (var i = 0; i < document.querySelectorAll('.timeline li').length; i++) {
							let iternaryHeader=[], iternaryBody="",iternaryResult=[];
								iternaryHeader=[document.querySelectorAll('.timeline li .timelineheading')[i].innerText.replace('\n','')];
								var iternaryElements=document.querySelectorAll('.timeline li')[i].querySelectorAll('li div:not(.item):not(.timelineheading)');
								for (var j = 0; j < iternaryElements.length; j++) {
									iternaryResult.push([iternaryElements[j].innerText]);
								}
								doc.autoTable({
							       theme: 'grid',     
							       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0] },
							      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
							      startY : yPos,
							      pageBreak: 'avoid',
							      tableWidth:tableWidth,
							      head:  [iternaryHeader],
							      body: iternaryResult,
							      columnStyles: {
                                     0: {cellWidth: 150},
							      },
					             didParseCell:enhanceWordBreak,
							      didDrawPage: function(data) {
								        yPos = data.cursor.y;
								    },
								     willDrawCell: function(data) {
		      							doc.setDrawColor(0, 0, 0); 
								    	if((data.row.index==iternaryResult.length-1 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		 doc.line(
										        data.cell.x,
										        data.cell.y + data.cell.height,
										        data.cell.x + data.cell.width,
										        data.cell.y + data.cell.height
										      );
										      doc.setLineWidth(0.25);	
								    	}
								    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								       }           
								   }
							    });
						}
						var div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Inclusions'");?>`;
	 						inclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Exclusions'"); ?>`;
	 						exclusions=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
						let totalExclustion=inclusions.length>exclusions.length? inclusions.length : exclusions.length;
						let inclusionsResults=[];
						for (var i = 0; i < totalExclustion; i++) {
							if(inclusions[i] || exclusions[i] ){
								var inclusionsText= inclusions[i];
								var exclusionsText=exclusions[i];
								inclusionsResults.push([
									inclusionsText?'• '+inclusionsText.replace("\t", "") : '',
									exclusionsText?'• '+exclusionsText.replace("\t", "") : ''
								])
							}
						}
						doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3}, fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth:0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},  cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      head:  [['Inclusions', 'Exclusions']],
					      body: inclusionsResults,
					      pageBreak: 'avoid',
					      didParseCell:enhanceWordBreak,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
						    		if((data.row.index==inclusionsResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								    		
								       }
						      }        
					    });
	 					   div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Cancellation Charges'"); ?>`;
	 						var cancallations=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Refunds'"); ?>`;
	 						var refunds=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 					let totalCancallations=cancallations.length>refunds.length? cancallations.length : refunds.length;
						let cancallationResults=[];
						for (var i = 0; i < totalCancallations; i++) {
								
							if(cancallations[i] || refunds[i] ){
								var cancallationsText= cancallations[i];
								var refundsText=refunds[i];
								cancallationResults.push([
									cancallationsText?'• '+cancallationsText.replace("\t", "") : '',
									refundsText?'• '+refundsText.replace("\t", "") : ''
								])
							}
						}
					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25}, fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					      pageBreak: 'avoid',
					      head:  [['Cancellation Charges', 'Refunds']],
					      didParseCell:enhanceWordBreak,
					       body: cancallationResults,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    } , 
						    willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
						    		if((data.row.index==cancallationResults.length-1 && data.section=='body' )){
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								       }
						      }         
					    });
					    	div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Bank Account'"); ?>`;
	 						var bankAccounts=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						div = document.createElement("div");
							div.innerHTML = `<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - UPI'"); ?>`;
	 						var upis=div.innerText.split('\n').filter(function(e) { return e.trim() != ''; });
	 						let bankAccountsText= "";
							let upiText="";
							let bankResults=[];
							let totalAccounts=bankAccounts.length>upis.length? bankAccounts.length : upis.length;
						for (var i = 0; i < totalAccounts; i++) {
							if(bankAccounts[i] || upis[i] ){
								bankAccountsText= bankAccounts[i];
								 upiText=upis[i];
								bankResults.push([
									bankAccountsText?bankAccountsText.replace("\t", "") : '',
									upiText?'• '+upiText.replace("\t", "") : ''
								])
							}
						}
					    doc.autoTable({
					       theme: 'grid',     
					       headStyles: { cellPadding: {top: 1, right: 3, bottom: 1, left: 3},fontSize: 9, fontStyle:'bold',fillColor: [216, 216, 216], lineWidth: 0.25,textColor: [2, 0, 0] ,lineColor:[2, 0, 0]},
					      bodyStyles: { cellPadding: {top: 0.5, right: 3, bottom: 0.5, left: 3},lineWidth :{top: 0, right: 0.25, bottom: 0, left: 0.25},fontSize: 9,lineColor:[2, 0, 0],textColor: [2, 0, 0] },       
					      startY : yPos+5,
					       pageBreak: 'avoid',
					      head:  [['Bank Account', 'UPI (Google Pay/BHIM/UPI/PhonePe)']],
					      didParseCell:enhanceWordBreak,
					      body: bankResults ,
					      didDrawPage: function(data) {
						        yPos = data.cursor.y;
						    },          
						     willDrawCell: function(data) {
      							doc.setDrawColor(0, 0, 0); 
						    	if((data.row.index==bankResults.length-1 && data.section=='body' )){	
						    		doc.setLineWidth(0.75);
						    		 doc.line(
								        data.cell.x,
								        data.cell.y + data.cell.height,
								        data.cell.x + data.cell.width,
								        data.cell.y + data.cell.height
								      );
								      doc.setLineWidth(0.25);	
						    	}
						    	if((data.row.index==0 && data.section=='body' )){
								    		doc.setLineWidth(0.75);
								    		doc.line(
										        data.cell.x + data.cell.width,
										        data.cell.y,
										        data.cell.x,
										        data.cell.y
										      );
										      doc.setLineWidth(0.25);
								       }
						      }
					    });
					    doc.text("Please read our company reviews by clicking the link - ", 15, yPos+10);
						doc.setTextColor(0, 0, 255);
					    doc.textWithLink('My Holiday Happiness reviews', doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, yPos+10, { url: 'https://www.google.com/search?q=my+holiday+happiness&oq=My+ho&aqs=chrome.0.69i59j69i57j69i60l2j69i59l2.1246j0j7&sourceid=chrome&ie=UTF-8#lrd=0x3bae3f2ed2301e45:0x89e7ba8485a43c37,1,,,' });
					    doc.setDrawColor( 0, 0,255);
					    doc.line( 
					    			 doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16, 
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h,
					    			doc.getTextDimensions("My Holiday Happiness reviews").w +  doc.getTextDimensions("Please read our company reviews by clicking the link - ").w+16,
					    			yPos+8+doc.getTextDimensions("My Holiday Happiness reviews").h);
						var pageCount = doc.internal.getNumberOfPages();
						for(i = 0; i < pageCount; i++) { 
						  doc.setPage(i); 
						  let pageCurrent = doc.internal.getCurrentPageInfo().pageNumber; 
						  doc.setFontSize(9);
						  doc.setTextColor(255, 0, 0);
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>', 10, doc.internal.pageSize.height - 10);
						  doc.text('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Phone No'"); ?>', doc.internal.pageSize.width-10-doc.getTextDimensions('<?php echo $this->Common_model->showname_fromid("par_value", "tbl_parameters", "parameter='PDF - Email Id'"); ?>').w, doc.internal.pageSize.height - 10);
						    doc.saveGraphicsState();
						    doc.setGState(new doc.GState({opacity: 0.1}));
						    doc.addImage(base64String, "PNG", 40, 80, 120, 60, undefined,'FAST');
						    doc.restoreGraphicsState();

						}
						doc.save(spackageName+".pdf");
						};
				}
				setTimeout(function () {
                  	downloadDetails();
                }, 1000);
			</script>
		</div>
