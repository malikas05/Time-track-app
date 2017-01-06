function colorAtag(element){
    if(jQuery(element).prop('selected')){
        var color = "0 0 10px 100px " + jQuery(element).attr('data-color') + " inset";
        jQuery(element).css('box-shadow', color );
    }else {
        jQuery(element).css('box-shadow', '' );
    }
}

function colorAproject(element, type){
    var color = jQuery(element).find(":selected").attr('data-color');
    jQuery(element).css('background-color', color );
    jQuery(element).css('color', getContrastYIQ(color, type));
}

function updateTask(data, parent){
    // Populate tags and projects with options
    var selectedTags =[];
    var selectedProject;
    user_data.tags.forEach(function(tag){
        jQuery(parent+" select.tags").append('<option val="'+tag.id+'"'+(!!tag.color? ' data-color="'+tag.color+'"' : "")+'>'+tag.name+'</option>');
        if (!!data.tagsApplied){
            for (var j=0, y= data.tagsApplied.length; j<y; j++){
                if(tag.id == data.tagsApplied[j]){
                    selectedTags.push(tag.name);
                }
            }
        }
    });
    user_data.projects.forEach(function(project){
        jQuery(parent+" select.projects").append('<option data-id="'+project.id+'"'+(!!project.color? ' data-color="'+project.color+'"' : "")+'>'+project.name+'</option>');
        if (!!data.projectApplied){
            if(project.id == data.projectApplied){ selectedProject = project.name; }
        }
        if (!!project.categories){
            for(var i=0, x= project.categories.length; i<x; i++){
                jQuery(parent+" select.projects").append('<option data-id="'+project.id+'"'+(!!project.color? ' data-color="'+project.color+'"' : "")+' data-category-id="'+project.categoryIDs[i]+'"'+'>&nbsp;&nbsp;&nbsp;'+project.categories[i]+" ("+project.name+')&nbsp;&nbsp;</option>');
                if (!!data.categoryApplied){
                    if(i == data.categoryApplied){ selectedProject = project.categories[i]+" ("+project.name+')'; }
                }
            }
        }
    });
    // Add time pickers and data based on what kind of tats it is old or current
    if( parent.match(/currentTask/i) === null ){
        // old task
        addTimePicker(parent+" input.startTime", (data.startTime*1000));
        addTimePicker(parent+" input.endTime", (data.endTime*1000));
        jQuery(parent+" select.projects").val(selectedProject);
        colorAproject(jQuery(parent+" select.projects"), "projectB");
        updateElapsedTime(parent, ":", data.startTime, data.endTime);
    }else{
        // current timer
        if(!!data.startTime){
            addTimePicker(parent+" input.startTime", (data.startTime*1000));
            startTimer();
            jQuery("#currentTask span.circleButton").addClass("stop").removeClass("play");
            jQuery("#currentTask span.circleButton span.glyphicon").addClass("glyphicon-stop").removeClass("glyphicon-play");
        }else {
            addTimePicker(parent+" input.startTime", false);
        }
        jQuery(parent+" select.projects").val(selectedProject);
        colorAproject(jQuery(parent+" select.projects"), "projectH");
    }
    // Populate with current data
    jQuery(parent+" input.taskName").val(data.name);
    jQuery(parent+" select.tags").val(selectedTags);
    jQuery(parent+' select.tags option').each(function(){colorAtag(this);});
}

function createOldTaskEntries(data, day, header) {
    temp = '<div class="dayOfTheWeek" id="'+day+'"><h3>'+header+'</h3></div>';
    jQuery("#tasksOfTheWeek").append(temp);
    data.forEach(function(task){
        temp='<div class="form-inline col-sm-12 old-task" id="'+task.id+'" data-task-id="'+task.id+'" data-day-id="'+day+'">'+
                '<div class="form-group" data-task-id="fGroup'+task.id+'" data-day-id="'+day+'">'+
                    '<div class="delete" data-task-id="deleteWrapper'+task.id+'" data-day-id="'+day+'">'+
                        '<a href="#" class="deleteTaskLink" data-task-id="'+task.id+'" name="delete'+task.id+'" data-day-id="'+day+'">'+
                            '<span class="glyphicon glyphicon-trash deleteTaskLink" data-task-id="trash'+task.id+'" data-day-id="'+day+'"  aria-hidden="true"></span>'+
                        '</a>'+
                    '</div>'+
                    '<input data-task-id="'+task.id+'" name="task'+task.id+'" data-day-id="'+day+'" type="text" class="form-control taskName" placeholder="Current Task Description" data-tag="Current Task Description" /><br />'+
                    '<select data-task-id="'+task.id+'" name="projects'+task.id+'" data-day-id="'+day+'" class="form-control projects"></select>'+
                    '<select data-task-id="'+task.id+'" name="tags'+task.id+'" data-day-id="'+day+'" class="form-control tags" multiple></select>'+
                    '<div class="timeSpent" data-task-id="timeSpent'+task.id+'" data-day-id="'+day+'">00:00</div>'+
                    '<div data-task-id="'+task.id+'" data-day-id="'+day+'"  class="timePoints">'+
                        '<input data-task-id="'+task.id+'" name="start'+task.id+'" data-day-id="'+day+'" class="form-control startTime" type="text" value="00:00"/>&#8209;'+
                        '<input data-task-id="'+task.id+'" name="end'+task.id+'" data-day-id="'+day+'" class="form-control endTime" type="text" value="00:00"/>'+
                    '</div>'+
                    '<div data-task-id="'+task.id+'" name="control'+task.id+'" data-day-id="'+day+'" class="taskControl playStopControlButton">'+
                        '<span class="circleButton stop playStopControlButton" data-task-id="circleButton'+task.id+'" data-day-id="'+day+'">'+
                            '<span class="glyphicon glyphicon-stop playStopControlButton" data-task-id="controlIcon'+task.id+'" data-day-id="'+day+'" aria-hidden="true"></span>'+
                        '</span>'+
                    '</div>'+
                '</div>'+
            '</div>';
        jQuery("#"+day).append(temp);
        updateTask(task, "#"+task.id);
    });
}

function updateTaskList() {
    var dateData = {
        weekly: {
            numbers:{ 0: "sun", 1: "mon", 2: 'tue', 3: "wed", 4: "thu", 5: "fri", 6: "sat" },
            days:{ "sun": 0, "mon":1, 'tue':2, "wed":3, "thu":4, "fri":5, "sat":6 },
            names:[ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
            dates:[]
        },
        montly: {
            monthNames: [
              "January", "February", "March",
              "April", "May", "June", "July",
              "August", "September", "October",
              "November", "December"
            ]
        }
    };
    var today = new Date();
    var dayHeader;
    var todayN = today.getDay();
    var temp;
    for (var i = 0; i < dateData.weekly.names.length; i++) {
        dateData.weekly.dates[i] = new Date(new Date().setDate(today.getDate() - todayN + i ))
    }
    for (day in user_data.thisweek){
        if( !!~day.indexOf(dateData.weekly.numbers[todayN]) ){
            dayHeader = "Today";
        }else{
            dayHeader = dateData.weekly.names[dateData.weekly.days[day]];
        }
        temp = dateData.weekly.dates[dateData.weekly.days[day]];
        dayHeader +=" - " + dateData.montly.monthNames[temp.getMonth()] +' ' + temp.getDate()+ ', ' + temp.getFullYear();
        if (!!user_data.thisweek[day]){
            createOldTaskEntries(user_data.thisweek[day], day, dayHeader);
        }
    }
}

    function messageModal(message, label, footer){
    var eText = "<p>" + message + "</p>";
    jQuery('#messageModalBody').html(eText);
    jQuery('#messageModalLabel').text(label);
    jQuery('#messageModalFooter').html(footer);
    if(errorFooter.length<1){
        jQuery('#messageModalFooter').css('border','none');
    }
    jQuery('#messageModal').modal('show');
}
