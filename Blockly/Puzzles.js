class Puzzles{

    constructor(obj,puzzles,index)
    {
        switch (puzzles[obj['2']['puzzles'][i]]['title']){
            case "Pincode Kluis":
                this.pin(obj,puzzles,index)
                break;
            case "kluis":
                this.kluis(obj,puzzles,index)
                break;
            


        
        }
    }

    pin(obj,puzzles,i){
        Blockly.Blocks[`${obj['2']['puzzles'][i]}`] = {
            init: function() {
              this.appendValueInput("NAME")
                  .setCheck(null)
                  .appendField(`${puzzles[obj['2']['puzzles'][i]]['title']}`);
              this.appendDummyInput()
                  .appendField(new Blockly.FieldNumber(1, 0, 9999), "code");
              this.setInputsInline(false);
              this.setOutput(true, null);
              this.setColour(this.getRandomInt(36) *10);
           this.setTooltip("");
           this.setHelpUrl("");
            }
          };

          Blockly.JavaScript[`${obj['2']['puzzles'][i]}`] = function(block) {
            var value_name = Blockly.JavaScript.valueToCode(block, 'NAME', Blockly.JavaScript.ORDER_ATOMIC);
            var number_code = block.getFieldValue('code');
            // TODO: Assemble JavaScript into code variable.
            var code = '...';
            // TODO: Change ORDER_NONE to the correct strength.
            return [code, Blockly.JavaScript.ORDER_NONE];
          };
    }
    kluis(obj,puzzles,i)
    {
        Blockly.Blocks[`${obj['2']['puzzles'][i]}`] = {
            init: function() {
              this.appendValueInput("NAME")
                  .setCheck(null)
                  .appendField(`${puzzles[obj['2']['puzzles'][i]]['title']}`);
              this.appendDummyInput()
                  .appendField(new Blockly.FieldAngle(255), "kluis");
              this.setInputsInline(false);
              this.setOutput(true, null);
              this.setColour(this.getRandomInt(36) *10);
           this.setTooltip("");
           this.setHelpUrl("");
            }
          };

          Blockly.JavaScript[`${obj['2']['puzzles'][i]}`] = function(block) {
            var value_name = Blockly.JavaScript.valueToCode(block, 'NAME', Blockly.JavaScript.ORDER_ATOMIC);
            var angle_kluis = block.getFieldValue('kluis');
            // TODO: Assemble JavaScript into code variable.
            var code = '...';
            // TODO: Change ORDER_NONE to the correct strength.
            return [code, Blockly.JavaScript.ORDER_NONE];
          };
        this.toolboxBlock(obj)
    }

   getRandomInt(max) { // func to get random color
        return Math.floor(Math.random() * max);
    }
    
    //   toolboxBlock(obj){ // add all created puzzles into the toolbox
    //     for(let i = 0; i < obj['2']['puzzles'].length;i++){
    //         $("#toolbox").append(`<block type = ${obj[2]['puzzles'][i]} ></block>`)
    //         demoWorkspace.updateToolbox(toolbox)
    //     }
    // }
    toolboxBlock(obj){ // add all created puzzles into the toolbox
            $("#toolbox").append(`<block type = ${obj['2']['puzzles'][i]} ></block>`)
            demoWorkspace.updateToolbox(toolbox)      
    }

}
module.exports = Puzzles;