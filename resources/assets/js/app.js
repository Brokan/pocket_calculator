
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));

/*const app = new Vue({
    el: '#app'
});*/

;(function () {
    var calculatorAPP = {
        //Container object
        container : null,
        //Field of number input
        inputField : null,
        //Number to remember.
        rememberNumber : null,
        rememberAction : null,
        //Actions
        actionsList : {
            sum : "sum",
            min : "min",
            div : "div",
            mult : "mult"
        },
        //Log textarea
        logField : null,
        /**
         * Inicialize function
         */
        init : function(){
            //Check for content.
            this.container = $("#calculator");
            if (this.container.length === 0){
                return;
            }
            this.inputField = this.container.find('input[name="calc"]');
            if (this.inputField.length === 0){
                return;
            }
            
            this.logField = this.container.find('textarea[name="logs"]');
            
            this.inputInsert();
            this.buttonActions();
        },
        /**
         * Set actions on buttons.
         */
        buttonActions : function() {
            var self = this;
            this.container.find('.calculator button').click(function(){
                var value = $(this).val();
                console.log(value);
                //Check action buttons
                switch (value) {
                    case "clear":
                        self.action.clear();
                        return;
                    case "sum":
                    case "min":
                    case "mult":
                    case "div":
                        self.setAction(value);
                        return;
                    case "eq":
                        self.action.equal();
                        return;
                    case ".":
                        var inputVal = self.getInputValue();
                        //Check is already has dot.
                        if (inputVal.indexOf(".") > 0){
                            return;
                        }
                }
                //Else this is number or dot.
                var text = self.inputField.val();
                if (text === "0" && value !== "."){
                    text = "";
                }
                self.inputField.val(text + value);
            });
        },
        /**
         * Key press on input field.
         */
        inputInsert : function(){
            var self = this,
                valInput = this.getInputValue();
        
            this.inputField.keydown(function(e){
                //Check is some action key is pressed.
                //console.log(e.which);
                //console.log(e.shiftKey);
                //console.log(e);
                switch (e.which) {
                    case 107://+
                        self.setAction(self.actionsList.sum);
                        return false;
                    case 109://-
                        self.setAction(self.actionsList.min);
                        return false;
                    case 106://*
                        self.setAction(self.actionsList.mult);
                        return false;
                    case 111:// divide
                        self.setAction(self.actionsList.div);
                        return;    
                    case 187://+ or =
                        if (e.shiftKey){ // +
                            self.setAction(self.actionsList.sum);
                            return false;
                        }
                        //Else =
                        self.action.equal();
                        return false;
                    case 189://- or _
                        if (!e.shiftKey){//-
                            self.setAction(self.actionsList.min);
                            return false;
                        }
                    case 56://* or 8
                        if (e.shiftKey){//*
                            self.setAction(self.actionsList.mult);
                            return false;
                        }
                    case 191:// divide
                        if (!e.shiftKey){// "/"
                            self.setAction(self.actionsList.div);
                            return false;
                        }
                    case 13:// Enter
                        self.action.equal();
                        return false;    
                }
                if (self.isSpecialKey(e) || self.isNumberFloatPress(e, valInput)){
                    //If enter number and has zero value, set only number.
                    var text = self.inputField.val();
                    if (text === "0" && self.isNumberPress(e)){
                        self.inputField.val("");
                    }
                    //Else this is number or dot.
                    return true;
                }
                
                e.preventDefault();
                return false;
            });
        },
        /**
         * Check is some special char is pressed.
         * @param Object e
         * @returns {Boolean}
         */
        isSpecialKey : function(e){
            if ([8, 9, 13, 16, 17, 18, 37, 38, 39, 40].indexOf(e.which) >= 0){
                //Backspace, Tab, Enter, Shift, Control, Alt, Arrows (4 directions)
                return true;
            }
            return false;
        },
        /**
         * Check is number pressed.
         * @param Object e
         * @returns {Boolean}
         */
        isNumberPress : function(e){
            if ((!e.shiftKey && e.which >= 48 && e.which <= 57) || (e.which >= 96 && e.which <= 105)) { //From 0 till 9
                return true;
            }
            return false;
        },
        /**
         * Check is number or point/dot is pressed.
         * @param Object e
         * @returns {Boolean}
         */
        isNumberFloatPress : function(e, val){
            if (this.isNumberPress(e)) {
                return true;
            }
            if (e.which === 190 && val.indexOf(".") < 0) { // . - only one dot allowed
                return true;
            }
            return false;
        },
        /**
         * Get value of text field.
         * @return float
         */
        getInputValue : function(){
            return this.inputField.val()*1;//*1 - convert to float
        },
        /**
         * Set value of text field.
         * @param name  strign
         */
        setInputValue : function(value){
            this.inputField.val(value);
        },
        /**
         * Get remembered value.
         * @return float
         */
        getRememberValue : function(){
            return this.rememberNumber*1;//*1 - convert to float
        },
        /**
         * Set remember value.
         * @param flaot val 
         */
        setRememberValue : function(val){
            this.rememberNumber = val*1;//*1 - convert to float
        },
        /**
         * Set remember action.
         * @param string action 
         */
        setRememberAction : function(action){
            this.rememberAction = action;
        },
        /**
         * Get remember action.
         * @return string
         */
        getRememberAction : function(){
            return this.rememberAction;
        },
        /**
         * Set action.
         * @param string action 
         */
        setAction : function(action){
            if (this.rememberAction !== null && this.rememberNumber !== null){
                var success = this.action.equal();
                if (!success){
                    return;
                }
            }
            this.setRememberAction(action);
            this.setRememberValue(this.getInputValue());
            this.setInputValue(0);
        },
        /**
         * Action events.
         */
        action : {
            /**
             * Action +
             */
            sum : function(val1, val2){
                return val1 + val2;
                
            },
            /**
             * Action -
             */
            minus : function(val1, val2){
                return val1 - val2;
            },
            /**
             * Action x
             */
            multiple : function(val1, val2){
                return val1 * val2;
            },
            /**
             * Action /
             */
            divide : function(val1, val2){
                if (val2 === 0){
                    return false;
                }
                return val1 / val2;
            },
            /**
             * Action C
             */
            clear : function(){
                calculatorAPP.rememberNumber = null;
                calculatorAPP.rememberAction = null;
                calculatorAPP.inputField.parent().removeClass('has-error');
                calculatorAPP.setInputValue(0);
            },
            /**
             * Action =
             */
            equal : function(){
                calculatorAPP.inputField.parent().removeClass('has-error');
                if (calculatorAPP.rememberAction === null || calculatorAPP.rememberNumber === null){
                    return;
                }
                var val1 = calculatorAPP.getRememberValue(),
                    val2 = calculatorAPP.getInputValue(),
                    result = 0,
                    log = val1 + " ";
                switch (calculatorAPP.rememberAction) {
                    case calculatorAPP.actionsList.sum:
                        result = this.sum(val1, val2);
                        log += "+ ";
                        break;
                    case calculatorAPP.actionsList.min:
                        result = this.minus(val1, val2);
                        log += "- ";
                        break;
                    case calculatorAPP.actionsList.mult:
                        result = this.multiple(val1, val2);
                        log += "x ";
                        break;
                    case calculatorAPP.actionsList.div:
                        result = this.divide(val1, val2);
                        log += "/ ";
                        break;
                }
                if (result === false){
                    //Error
                    calculatorAPP.inputField.parent().addClass('has-error');
                    return false;
                }
                calculatorAPP.setInputValue(result);
                calculatorAPP.rememberAction = null;
                //Create log.
                log += val2 + " = " + result;
                calculatorAPP.logSave(log);
                
                return true;
            }
        },
        //Save log to textarea
        logSave : function(logText){
            this.logField.val(this.logField.val() + logText + "\n\
");
        }
    },
    /**
     * To work with logs.
     */
    logsAPP = {
        //Container object
        container : null,
        //Log Textarea
        logField : null,
        //URLs
        urlLogSave : null,
        urlLogLoadById : null,
        urlLogLoadByName : null,
        /**
         * Inicialize function
         */
        init : function(){
            //Check for content.
            this.container = $("#calculator .logs");
            if (this.container.length === 0){
                return;
            }
            this.urlLogSave = this.container.find('input[name="urlLogSave"]').val();
            this.urlLogLoadById = this.container.find('input[name="urlLogLoadById"]').val();
            this.urlLogLoadByName = this.container.find('input[name="urlLogLoadByName"]').val();
            this.logField = this.container.find('textarea[name="logs"]');
            if (this.urlLogSave.length === 0 || this.urlLogLoadById.length === 0 || this.urlLogLoadByName.length === 0 || this.logField.length === 0){
                return;
            }
            this.setActions();
        },
        setActions : function(){
            var self = this;
            //On save button
            this.container.find('button[name="save_log"]').click(function(){
                self.saveLogs();
            });
            //On load button
            this.container.find('button[name="log_load"]').click(function(){
                self.loadLogsByName();
            });
            //On select dropdown
            this.container.find('select[name="search"]').change(function(){
                self.loadLogsById($(this).val());
            });
        },
        saveLogs : function(){
            //Check name
            var self = this,
                nameInput = this.container.find('input[name="log_name"]'),
                name = $.trim(nameInput.val());
            if(name === ""){
                nameInput.parent().addClass("has-error");
                return;
            }
            nameInput.parent().removeClass("has-error");
            var logs = this.logField.val();
                    
            $.post(this.urlLogSave, {"_token" : window.Laravel.csrfToken, "name" : name, "logs" : logs}, function(response){
                console.log(response);
                if (response.hasOwnProperty("id")){
                    self.addOptionToDrop(response['id'], response['name']);
                    return;
                }
                nameInput.parent().addClass("has-error");
            }, 'json');
        },
        loadLogsByName : function(){
            //Check name
            var self = this,
                nameInput = this.container.find('input[name="search"]'),
                name = $.trim(nameInput.val());
            if(name === ""){
                nameInput.parent().addClass("has-error");
                return;
            }
            $.post(this.urlLogLoadByName, {"_token" : window.Laravel.csrfToken, "name" : name}, function(response){
                console.log(response);
                if (response.hasOwnProperty("logs")){
                    self.logField.val(response.logs);
                    nameInput.val(response.name)
                    return;
                }
                nameInput.parent().addClass("has-error");
            }, 'json');
        },
        loadLogsById : function(id){
            var self = this;
            $.post(this.urlLogLoadById, {"_token" : window.Laravel.csrfToken, "id" : id}, function(response){
                console.log(response);
                if (response.hasOwnProperty("logs")){
                    self.logField.val(response.logs);
                }
            }, 'json');
        },
        addOptionToDrop : function(id, name){
            //Check for same ID
            if (this.container.find('select[name="search"] option[value="'+id+'"]').length > 0){
                return;
            }
            var option = $("<option value='"+id+"'>"+name+"</option>");
            this.container.find('select[name="search"]').append(option);
        }
    };
    
    $( document ).ready(function() {
        calculatorAPP.init();
        logsAPP.init();
    });
}());