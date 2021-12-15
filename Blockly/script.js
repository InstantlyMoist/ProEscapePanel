/*
TODO need big cleanup of code
  Perhaps put code in class / find out a way to use classes correctly with browser javascript
  give more options by the puzzle
  unique blocks for puzzles that get loaded
  roomid is  hardcoded by load blocks

  Check error with last jquery call currently only using always
*/

let roomID = "3";
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
function prepBlock(puzzles,rooms){
  for(let i =0; i< rooms[roomID]['puzzles'].length;i++){
    puzzles[rooms[roomID]['puzzles'][i]]['title']
  }
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
        alert("Roomcode has been send")
        stepCount = 1;
      }else{
        alert("Something went wrong "+ errorThrown.status); 
        demoWorkspace.clear() ;
        stepCount = 1    
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




///Functions used
function loadBlocks(obj,puzzles){/// Dynamic load in block from array 
    for(let i = 0; i < obj[roomID]['puzzles'].length;i++){
      block = new PuzzlesBlock(obj, puzzles, i)
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




class PuzzlesBlock{
  constructor(obj,puzzles,i)
  {
      switch (puzzles[obj[roomID]['puzzles'][i]]['title']){
          case "Pincode Kluis":
              this.pin(obj,puzzles,i)
              break;
          case "Kluis":
              this.kluis(obj,puzzles,i)
              break;
          default: 
            this.noCode(obj,puzzles,i)
      }
  }

  pin(obj,puzzles,i){
    let color = (this.RandomInt(36)*5)
      Blockly.Blocks[`${obj[roomID]['puzzles'][i]}`] = {
          init: function() {
            this.appendValueInput("NAME")
                .setCheck(null)
                .appendField(`${puzzles[obj[roomID]['puzzles'][i]]['title']}`);
            this.appendDummyInput()
                .appendField("Code voor pin")
                .appendField(new Blockly.FieldNumber(1, 0, 9999), `${obj[roomID]['puzzles'][i]}`);
            this.setInputsInline(false);
            this.setOutput(true, null);
            this.setColour(color);
         this.setTooltip("");
         this.setHelpUrl("");
          },

        };

        Blockly.JavaScript[`${obj[roomID]['puzzles'][i]}`] = function(block) {
          var value_name = Blockly.JavaScript.valueToCode(block, 'NAME', Blockly.JavaScript.ORDER_ATOMIC);
          var number_code = block.getFieldValue('code');
          // TODO: Assemble JavaScript into code variable.
          var code = '...';
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.JavaScript.ORDER_NONE];
        };
        this.toolboxBlock(obj,i)
  }
  kluis(obj,puzzles,i)
  {
    let color = (this.RandomInt(36)*5)
      Blockly.Blocks[`${obj[roomID]['puzzles'][i]}`] = {
          init: function() {
            this.appendValueInput("NAME")
                .setCheck(null)
                .appendField(`${puzzles[obj[roomID]['puzzles'][i]]['title']}`);
            this.appendDummyInput()
                .appendField("Code voor kluis")
                .appendField(new Blockly.FieldNumber(1, 0, 9999), `${obj[roomID]['puzzles'][i]}`);
            this.setInputsInline(false);
            this.setOutput(true, null);
            this.setColour(color);
         this.setTooltip("");
         this.setHelpUrl("");
          }
        };
        Blockly.JavaScript[`${obj[roomID]['puzzles'][i]}`] = function(block) {
          var value_name = Blockly.JavaScript.valueToCode(block, 'NAME', Blockly.JavaScript.ORDER_ATOMIC);
          var angle_kluis = block.getFieldValue('kluis'); 
          // TODO: Assemble JavaScript into code variable.
          var code = '...';
          // TODO: Change ORDER_NONE to the correct strength.
          return [code, Blockly.JavaScript.ORDER_NONE];
        };
        this.toolboxBlock(obj,i)
        
  }
  noCode(obj,puzzles,i){
    Blockly.Blocks[`${obj[roomID]['puzzles'][i]}`] = {
      init: function() {
        this.appendValueInput("NAME")
            .setCheck(null)
            .appendField(`${puzzles[obj[roomID]['puzzles'][i]]['title']}`);
        this.setInputsInline(false);
        this.setOutput(true, null);
        this.setColour(0);
     this.setTooltip("");
     this.setHelpUrl("");
      }
    };
    Blockly.JavaScript[`${obj[roomID]['puzzles'][i]}`] = function(block) {
      var value_name = Blockly.JavaScript.valueToCode(block, 'NAME', Blockly.JavaScript.ORDER_ATOMIC);
      // TODO: Assemble JavaScript into code variable.
      var code = '...';
      // TODO: Change ORDER_NONE to the correct strength.
      return [code, Blockly.JavaScript.ORDER_NONE];
    };
    this.toolboxBlock(obj,i)
  }

 RandomInt(max) { // func to get random color // werkt momenteel niet
      return Math.floor(Math.random() * max);
  }

  toolboxBlock(obj,i){ // add all created puzzles into the toolbox
          $("#toolbox").append(`<block type = ${obj[roomID]['puzzles'][i]} ></block>`)
          demoWorkspace.updateToolbox(toolbox)
          blockLimit[obj[roomID]['puzzles'][i]] = 1
          demoWorkspace.options.maxInstances = blockLimit
  }

}



