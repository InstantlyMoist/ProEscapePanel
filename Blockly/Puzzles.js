//location of block used for puzzles
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
            $("#Puzzles").append(`<block type = ${obj[roomID]['puzzles'][i]} ></block>`)
            demoWorkspace.updateToolbox(toolbox)
            blockLimit[obj[roomID]['puzzles'][i]] = 1
            demoWorkspace.options.maxInstances = blockLimit
    }
  
  }
  
module.exports = Puzzles;