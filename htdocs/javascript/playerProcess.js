var PLAYER_PROCESS = SITE_URL+"/ajax/playerProcess.php";
var POWER_PREVIEW_URI = SITE_URL+'/ajax/power.php';
var STATUS_DEAD = 'Dead';
var STATUS_UNCONSCIOUS = 'Unconscious';
var STATUS_BLOODIED = 'Bloodied';

var notes_tmp = '';

function updateCurrentHealth(health_cur) {
	updateText('#health_cur', health_cur)
	//$('#health_cur').text(health_cur);
	var health_max = $('#health_max').text();
	var bloodied_val = Math.floor(health_max/2);
	
	$('#health_cur').removeClass();
	$('#health_status').removeClass();
	$('#health_status').text('');
	
	// Are we Dead?
	if( health_cur < -1*bloodied_val ) {
		$('#health_cur').addClass(STATUS_DEAD);
		$('#health_status').addClass(STATUS_DEAD);
		$('#health_status').text(STATUS_DEAD);
	}
	else if( health_cur < 1 ) {
		$('#health_cur').addClass(STATUS_UNCONSCIOUS);
		$('#health_status').addClass(STATUS_UNCONSCIOUS);
		$('#health_status').text(STATUS_UNCONSCIOUS);
	}
	else if( health_cur < bloodied_val ) {
		$('#health_cur').addClass(STATUS_BLOODIED);
		$('#health_status').addClass(STATUS_BLOODIED);
		$('#health_status').text(STATUS_BLOODIED);
	}	
}
function updateTempHealth(health_tmp) {
	if( health_tmp > 0 ) {
		updateText('#health_tmp', '('+health_tmp+')');
		//$('#health_tmp').text('('+health_tmp+')');
	}
	else {
		updateText('#health_tmp', '');
		//$('#health_tmp').text('');
	}
}

function togglePower(pID, action) {
	action = 'refresh' == action ? action : 'use';	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			p_id: pID,
			action: action+'Power'
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				animatePower(pID, action);
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function animatePower(pID, action) {
	var rowID = '#i'+pID;
	var hideIcon, showIcon, rowOpacity;
	if( 'refresh' == action ) {
		hideIcon = '#r'+pID;
		showIcon = '#u'+pID;
		rowOpacity = 1;
	}
	else {
		action = 'use';
		hideIcon = '#u'+pID;
		showIcon = '#r'+pID;
		rowOpacity = .5;
	}
	
	$(hideIcon+':visible').fadeOut('fast', function() {
		$(rowID).fadeTo('fast', rowOpacity, function() {
			$(showIcon).fadeIn('fast');
		});
	});
}

function updateSurges(op) {
	var op_string = op+'Surge';
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: op_string
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];

			if( PROCESS_FAILURE != result ) {
				updateText('#surges_cur', result);
				//$('#surges_cur').text(result);
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function spendSurge() {
	var surge_bonus = $('#surge_bonus').val();
	var response;
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: 'spendSurge',
			surge_bonus: surge_bonus
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				var info = result.split(RESULT_DELIMITER);
				
				$('#surge_bonus').val('');
				updateText('#surges_cur', info[0]);
				//$('#surges_cur').text(info[0]);
				updateCurrentHealth(info[1]);				
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function updateActionPoints(op) {
	var op_string;
	if( 'subtract' == op ) {
		op_string = 'subtractActionPoint';
	}
	else {
		op_string = 'addActionPoint';
	}

	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: op_string
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				updateText('#action_points', result);
				//$('#action_points').text(result);
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function updateMagicItemUses(op) {
	var op_string;
	if( 'subtract' == op ) {
		op_string = 'subtractMagicItemUse';
	}
	else {
		op_string = 'addMagicItemUse';
	}

	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: op_string
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				updateText('#magic_item_uses', result);
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}


function doRest(restType) {
	var divClass = 'short'==restType?'Encounter':'titleBar';
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: 'rest',
			rest_type: restType
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0].split(RESULT_DELIMITER);
			
			if( PROCESS_FAILURE != result ) {
				// Reset temp HP.
				updateTempHealth(0);
								
				if( 'extended' == restType ) {
					var subText;
					// If we're an Extended Rest,
					// Set Current Health to Maximum Health
					updateCurrentHealth($('#health_max').text());
					// Set Current Surges to Maximum Surges
					updateText('#surges_cur', $('#surges_max').text());
					// Reset Action Points
					updateText('#action_points', result[0]);
					// Rest Magic Item Uses
					updateText('#magic_item_uses', result[1]);
				}
			}
			
			$('img.power_refresh:visible').each(function() {
				animatePower(this.id.substring(1), 'refresh');
			});
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function adjustHealth() {
	var damage = $('#damage_value').val();
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: 'damage',
			health: damage
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				var info = result.split(RESULT_DELIMITER);
				// Adjust Current Health
				updateCurrentHealth(info[0]);
				// Adjust Temporary Health
				updateTempHealth(info[1]);
				$('#damage_value').val('');
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function addTempHealth() {
	var health = $('#health').val();
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: 'tempHealth',
			health: health
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				updateTempHealth(result);
				$('#health').val('');
			}
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		}
	);
}

function updateNotes() {
	var notesText = $('#player_notes').val();
	
	$.post(PLAYER_PROCESS,
		{
			id: CHAR_ID,
			action: 'updateNotes',
			notes: notesText
		},
		function(data) {
			var response = data.split(MESSSAGE_DELIMITER);
			var result = response[0];
			
			if( PROCESS_FAILURE != result ) {
				// At this point result stores the current value of the notes field.
				// However, since we're just dumping the content of the textarea into
				// the field, we don't actually HAVE to push this update back out.
				//
				// Still, we're going to anyway, to make sure that post-update we're
				// displaying the current content. This allows us to be sure we're
				// correct when setting the dirty/clean notification to clean
				$('#player_notes').val(result);
			
				// Now, set the dirty state to 'clean'
				$('#notes_dirty').fadeOut();
			}
			
			if( response.length > 1 ) {
				printMessage(new Array(response[1],response[2]));
			}
		});
}

function notesDirtyCheck() {
	var notes_cur = $('#player_notes').val()
	
	if( notes_tmp != notes_cur ) {
		$('#notes_dirty').fadeIn();
	}
}

function updateText(id, data) {
	$(id).fadeOut(function() {
		$(id).text(data)
		$(id).fadeIn();
	});
}

$(window).load(function() {
	// Preload Images
	var img1 = $('<img />').attr('src', MEDIA_URL+'/images/icon_refresh.png');
	var img2 = $('<img />').attr('src', MEDIA_URL+'/images/icon_use.png');
	
	
	// Fill the notes_tmp variable
	notes_tmp = $('#player_notes').val();
	// Handle dirty notification for player notes
	$('#player_notes').keyup(function(k) { notesDirtyCheck() });
	
	// Power Usage
	$('#PowerTable img.power_use').click(function() { 
		togglePower(this.id.substring(1), 'use'); });
	$('#PowerTable img.power_refresh').click(function() { 
		togglePower(this.id.substring(1), 'refresh'); });
	
	// Healing Surges
	$("#surgePlus").click(function() { updateSurges('add') });
	$("#surgeMinus").click(function() { updateSurges('subtract') });
	$("#spendSurge").click(function() { spendSurge() });

	// Action Points
	$('#apPlus').click(function() { updateActionPoints('add') });
	$('#apMinus').click(function() { updateActionPoints('subtract') });

	// Magic Item Uses
	$('#miPlus').click(function() { updateMagicItemUses('add') });
	$('#miMinus').click(function() { updateMagicItemUses('subtract') });
	
	// Rest Actions
	$('#shortRest').click(function() { doRest('short') });
	$('#extendedRest').click(function() { doRest('extended') });
	
	// Damage/Health/Temp Health
	$('#takeDamage').click(function() { adjustHealth() });
	$('#tempHealth').click(function() { addTempHealth() });
	
	// Player notes
	$('#updateNotes').click(function() { updateNotes() });
	
	// Enable form fields on pressing enter/return
	$('#damage_value').keyup(function(e) { if(e.keyCode==13) adjustHealth(); });
	$('#health').keyup(function(e) { if(e.keyCode==13) addTempHealth(); });
	$('#surge_bonus').keyup(function(e) { if(e.keyCode==13) spendSurge(); });
	
	// Power Tooltips
	$('img.power_view').each(function(i) {
		var id = this.id.substring(1);
		$(this).qtip({
			content: {
				url: POWER_PREVIEW_URI,
				method: 'post',
				data: {
					id: CHAR_ID,
					p_id: id
				}
			},
			position: { 
				adjust: { 
					screen: true
				},
				corner: {
					target: 'leftMiddle',
					tooltip: 'topRight'
				}
			},
			show: {
				solo: true,
				when: {
					event: 'click'
				}
			},
			hide: {
				when: {
					event: 'click'
				}
			},
			style: {
				width: 308,
				padding: 0,
				background: '#FFFFFF',
				border: { 
					width: 1,
					radius: 3
				}
			},
			api: {
				//beforeShow: function() { $('.power_view').qtip('hide'); }
			}
		}); // End qTip()
	}); //end each()
}); //end ready()