/*
TODO need big cleanup of code
  Perhaps put code in class / find out a way to use classes correctly with browser javascript
  roomid is  hardcoded by load blocks
*/

// gets roomID from url
let param = window.location.search
let urlParam =  new URLSearchParams(param)

let roomID = urlParam.get('roomID');
//var needed to only allow these blocks to be used once

let blockLimit ={'end_step': 1,
'room_top': 1}
// jquery
$(document).ready(() =>{
    $.ajax({
        url: `http://localhost:3000/api/rooms`,
    })
    .done(data =>{  
        if (!data) return console.log("something went wrong with requesting data");
        console.log(data)
        $("#room").append(`<b>${data[roomID]['title']}</b>`)
        loadpuzzles(data);
        
    })
})


function loadpuzzles(obj){
  $.ajax({
    url: `http://localhost:3000/api/puzzles`,
})
.done(data =>{
    if (!data) return console.log("something went wrong with requesting data");
    loadBlocks(obj,data)
})
}
function send(){ // TO DO change always to done or succes
    $.ajax({
        url: `http://localhost:3000/api/puzzle/blockly`,
        data :  {"order":roomOrder,
      "code":blockCode,
      "roomID":roomID},
        type : "post",
        crossDomain: true,
    })
    .always(function(jqXHR, textStatus, errorThrown){
      if (errorThrown.status == 200){
        demoWorkspace.clear();
        window.location.href = `https://localhost/room/${roomID}`; // using local host not sure if this will work forever
      }else{
        alert("Something went wrong "+ errorThrown.status); 
        demoWorkspace.clear() ;
        Blockly.Xml.domToWorkspace(document.getElementById('block'),
        demoWorkspace);   
      }
    })

}

//array with order of puzzles
let puzzlesBlocks = [];
// BEGINNING BLOCK AND ENDING BLOCK
Blockly.Blocks['steps'] = {
  init: function() {
    this.appendValueInput("Steps")
        .setCheck(null)
        .appendField("Step");
    this.setPreviousStatement(true, null);
    this.setNextStatement(true, null);
    this.setColour(230);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};


Blockly.Blocks['room_top'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Room");
    this.setNextStatement(true, null);
    this.setColour(230);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['end_step'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("END");
    this.setPreviousStatement(true, null);
    this.setColour(230);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};

Blockly.JavaScript['end_step'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  // dissectBlock(block)
  let code = '...;\n';
  return code;
};

Blockly.JavaScript['room_top'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  dissectBlock(block)
  let code = '...;\n';
  return code;
};

Blockly.JavaScript['steps'] = function(block) {
  let value_steps = Blockly.JavaScript.valueToCode(block, 'Steps', Blockly.JavaScript.ORDER_ATOMIC);
  // TODO: Assemble JavaScript into code variable.
  let code = '...;\n';
  return code;
};



function loadBlocks(obj,puzzles){/// Dynamic load in block from array 
    for(let i = 0; i < obj[roomID]['puzzles'].length;i++){
       new PuzzlesBlock(obj, puzzles, i)
    }
}

function dissectBlock(obj){
 Object.keys(obj).forEach(key =>{
  if (key == ['childBlocks_']){
     if (obj['childBlocks_'].length === 0){ // check if block has a block attached
       return
     }
     let index = 0 // var needed to tell which index we want to continue in
     if (obj['childBlocks_'].length === 2){ // if puzzle is attached check if step is in the correct array
        let type = obj['childBlocks_'][0]['type'];
        if(!type.includes("step")){ // check which array the puzzle is located
          puzzleDissect(obj['childBlocks_'][0])
          index = 1;
        }else{
          puzzleDissect(obj['childBlocks_'][1])
        }
     }
     dissectBlock(obj[key][index])
   }
 })
}   
stepCount = 1
let roomOrder = {}
let blockCode = {}

function puzzlesBlocksFinish(){ // finish the array when all the puzzle are inserted
  roomOrder[`step_${stepCount}`] = puzzlesBlocks
  stepCount++;
  puzzlesBlocks = [];
}

function puzzleDissect(obj){// dissect the json where the puzzles are located
  Object.keys(obj).forEach(key =>{
    if (key == ['childBlocks_']){
      
      let  name = obj['type'];
      let value = obj.getFieldValue(name)
      
      blockCode[name] = value
      puzzlesBlocks.push(obj['type'])      
      if (obj['childBlocks_'].length === 0){ // check if block has a block attached
        puzzlesBlocksFinish() 
        return
      }
      puzzleDissect(obj[key][0])
    } 
  })
}







