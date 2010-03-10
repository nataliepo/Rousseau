
function display_comments (json_response) {
    alert("[get_comments_snippet]");

    var braided_comments = document.getElementById("braided-comments");
    
    if (!braided_comments) {
        // fail silently;
        return;
    }

    alert("Found div.");
    
    var innerHTML = "<h2>Comments</h2>";
    innerHTML += "<ol>";
    
    for (i = 0; i < json_response.entries.length; i++) {
        innerHTML += print_individual_comment(json_response.entries[i]); 
    }
    innerHTML += "</ol>";
    
    braided_comments.innerHTML = innerHTML;
    return;
}


function display_entry(json_response) {    
    var braided = document.getElementById("braided-entry");
    
    if (!braided) {
        // fail silently
        return;
    }
    
    var innerHTML = "";
    
    for (i = 0; i < json_response.entries.length; i++) {
        innerHTML += add_entry_snippet(json_response.entries[i]);
    //    innerHTML += add_comments_snippet(json_response.entries[i]);
    }
        
    braided.innerHTML = innerHTML;

    return;
}


function display_tp_comments (json_response) {
    var braided_comments = documents.getElementById("braided-comments");
    if (!braided_comments) {
        return;
    }
    
    var innerHTML = "";
    
    
}

function add_entry_snippet (entry) {
    
    var entry_contents = 
'<div class="entry" id="' + entry.urlId + '"> \n' + 
'   <h2>' + get_entry_title(entry) + '</h2>\n' + 
'   <div class="entry-body">\n' +
'       ' + get_entry_contents(entry) +  '\n' +
'   </div>\n' + 
'</div>\n';

    return entry_contents;
}


function get_entry_title (entry) {
    if (entry.title) {
        return entry.title;
    }   
    
    return "[Untitled Entry]";
}

function get_entry_contents (entry) {
    return entry.renderedContent;
}

function add_comments_snippet(entry) {
    alert("[add_comments_snippet]");
    
    var innerHTML = "<h2>Comments</h2>";
    
    // There should only be one entry in this json obj. 
    // Regardless, only work with the first.
    
    innerHTML += '<div class="comment-loop">\n' ;
    innerHTML += '<ul>';
    for (i = 0; i < json_response.entries[0].length; i++) {
        innerHTML += print_individual_comment(json_response.entries[0][i]);
    }
    innerHTML += '</ul>';
    
    return innerHTML;
}




function print_individual_comment (comment) {
    return '<li>' + comment.content + '</li> \n';
}
