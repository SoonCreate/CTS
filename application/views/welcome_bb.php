fdsfdsf

<div class="row">
    <div id="ajax_error" data-dojo-type="dijit/form/Button">
        <label>ajax_error</label>
    </div>

    <div id="ajax_warning" data-dojo-type="dijit/form/Button">
        <label>ajax_warning</label>
    </div>

    <div id="ajax_info" data-dojo-type="dijit/form/Button">
        <label>ajax_info</label>
    </div>
</div>
<div class="row">
    <div name="DepartmentAdd" id="DepartmentAdd" value="增加供应商" data-dojo-type="dijit/form/Button">
        <label>默认按钮</label>
     </div>
     <span  data-dojo-type="dijit/form/TextBox" class="">
     </span>
</div>
<div class="row">
    <button data-dojo-type="dijit/form/Button" > <label>默认中文</label></button>
    <button data-dojo-type="dijit/form/Button" class="primary" > <label>primary</label></button>
    <button data-dojo-type="dijit/form/Button" class="warning" > <label>warning</label></button>
    <button data-dojo-type="dijit/form/Button" class="danger" > <label>danger</label></button>
    <button data-dojo-type="dijit/form/Button" class="success" > <label>success</label></button>
    <button data-dojo-type="dijit/form/Button" class="info" > <label>info</label></button>
    <button data-dojo-type="dijit/form/Button" class="inverse" > <label>inverse</label></button>
</div>
<div class="row">
    <button data-dojo-type="dijit/form/Button" class="btnrad3"> <label>直角中文</label></button>
    <button data-dojo-type="dijit/form/Button" class="primary btnrad3" > <label>primary</label></button>
    <button data-dojo-type="dijit/form/Button" class="warning btnrad3" > <label>warning</label></button>
    <button data-dojo-type="dijit/form/Button" class="danger btnrad3" > <label>danger</label></button>
    <button data-dojo-type="dijit/form/Button" class="success btnrad3" > <label>success</label></button>
    <button data-dojo-type="dijit/form/Button" class="info btnrad3" > <label>info</label></button>
    <button data-dojo-type="dijit/form/Button" class="inverse btnrad3" > <label>inverse</label></button>

</div>
<div class="row">
    <button data-dojo-type="dijit/form/Button" class="" disabled="true"> <label>圆角中文</label></button>
    <button data-dojo-type="dijit/form/Button" class="primary" disabled="true"> <label>primary</label></button>
    <button data-dojo-type="dijit/form/Button" class="warning" disabled="true" > <label>warning</label></button>
    <button data-dojo-type="dijit/form/Button" class="danger" disabled="true" > <label>danger</label></button>
    <button data-dojo-type="dijit/form/Button" class="success" disabled="true" > <label>success</label></button>
    <button data-dojo-type="dijit/form/Button" class="info" disabled="true" > <label>info</label></button>
    <button data-dojo-type="dijit/form/Button" class="inverse" disabled="true" > <label>inverse</label></button>            </div>
<div class="row">
    <button data-dojo-type="dijit/form/Button" class=""> <i class="icon-user icon-1x"></i><label>圆角中文</label></button>
    <button data-dojo-type="dijit/form/Button" class="primary" > <i class="icon-folder-close"></i><label>primary</label></button>
    <button data-dojo-type="dijit/form/Button" class="warning" > <i class="icon-volume-up"></i><label>warning</label></button>
    <button data-dojo-type="dijit/form/Button" class="danger" > <i class="icon-laptop"></i><label>danger</label></button>
    <button data-dojo-type="dijit/form/Button" class="success" > <i class="icon-signal"></i><label>success</label></button>
    <button data-dojo-type="dijit/form/Button" class="info" ><i class="icon-book"></i> <label>info</label></button>
    <button data-dojo-type="dijit/form/Button" class="inverse" > <i class="icon-envelope-alt"></i><label>inverse</label></button>
</div>
<div class="row">
    <input  data-dojo-type="dijit/form/TextBox" data-dojo-props="required:true" missingMessage="必须输入"> </input>
</div>
<div class="row">
    <div id="" data-dojo-type="dijit/form/Select" data-dojo-props="value:'AK'">
        <span data-dojo-value="AL">hahahal</span>
        <span data-dojo-value="AK">供应商</span>
        <span data-dojo-value="AZ">AZAZ我</span>
        <span data-dojo-value="AR">你好AR</span>
        <span data-dojo-value="CA">this is ca</span>
    </div>



    <div name="DepadtmentAdd" id="Departmdd" value="增加供应商" data-dojo-type="dijit/form/Button">
        <label>默认按钮</label>
    </div>
</div>
<div class="row">
    <input  data-dojo-type="dijit/form/TextBox"> </input>
    <select  id="depttype" name="depttype" data-dojo-type="dijit/form/Select"  trim="true" value="A">
        <option value ='B' >我现在选中的是AK</option>
        <option value ='A'>我现在选中的是AK</option>
        <option value ='C'>我现在选中的是AK</option>
        <option value ='D'>我现在选中的是AK</option>
    </select>
    <div data-dojo-type="dijit/form/Button" class="inverse" disabled="true" > <label>inverse</label></div>
    <div data-dojo-type="dijit/form/DropDownButton" data-dojo-props="">
        <span>Drop Down</span>
        <div data-dojo-type="dijit/Menu" id="editMenu1" style="display: none;">
            <div data-dojo-type="dijit/MenuItem" data-dojo-props="">Cut</div>
        </div>
    </div>
</div>
<div class="row">
    <hr class="spacer">
    <button data-dojo-type="dijit.form.Button" data-dojo-props='iconClass:"dijitIconTask", disabled:true' disabled>Simple</button>
    <div data-dojo-type="dijit.form.DropDownButton" data-dojo-props='iconClass:"dijitIconEdit", disabled:true'>
        <span>Drop Down</span>
        <ul data-dojo-type="dijit.Menu" id="editMenu2" style="display: none;">
            <li data-dojo-type="dijit.MenuItem" data-dojo-props="
                            iconClass:'dijitIconCut'
                        ">Cut</li>

            <li data-dojo-type="dijit.MenuItem" data-dojo-props="
                            iconClass:'dijitIconCopy'
                        ">Copy</li>

            <li data-dojo-type="dijit.MenuItem" data-dojo-props="
                            iconClass:'dijitIconPaste'
                        ">Paste</li>
        </ul>
    </div>

    <div data-dojo-type="dijit/form/ComboButton" data-dojo-props="iconClass:'dijitIconSave', optionsTitle:'save options', disabled:true">
        <span>Combo</span>
        <div data-dojo-type="dijit.Menu" id="saveMenu2" style="display: none;">
            <div data-dojo-type="dijit.MenuItem" data-dojo-props="
                            iconCLass:'dijitIconSave'
                        ">Save</div>
            <div data-dojo-type="dijit.MenuItem">
                Save As
            </div>
        </div>
    </div>
    <button data-dojo-type="dijit.form.ToggleButton" data-dojo-props="checked:true, disabled:true, iconClass:'dijitCheckBoxIcon'">
        Toggle
    </button>

</div>

<div class="row">
    <h2>CheckBox</h2>
    <fieldset>
        <input id="check1" type="checkBox" data-dojo-type="dijit/form/CheckBox">
        <label for="check1">未选中</label>

        <input id="check2" type="checkBox" data-dojo-type="dijit/form/CheckBox" data-dojo-props="checked:true" checked="checked">
        <label for="check2">选中</label>

        <input id="check3" type="checkBox" data-dojo-type="dijit/form/CheckBox" data-dojo-props='disabled:true' disabled>
        <label for="check3">disabled</label>

        <input id="check4" type="checkBox" data-dojo-type="dijit/form/CheckBox"	 data-dojo-props='disabled:true, checked:true' checked="checked" disabled>
        <label for="check4">disabled and checked</label>
    </fieldset>

    <h2>Radio Buttons</h2>
    <fieldset>
        <input type="radio" name="g1" id="g1rb1" value="news" data-dojo-type="dijit/form/RadioButton">
        <label for="g1rb1">news</label>
        <input type="radio" name="g1" id="g1rb2" value="talk" data-dojo-type="dijit/form/RadioButton"  data-dojo-props='checked:true' checked>
        <label for="g1rb2">talk</label>
        <input type="radio" name="g1" id="g1rb3" value="weather" data-dojo-type="dijit/form/RadioButton"  data-dojo-props='disabled:true' disabled>
        <label for="g1rb3">weather (disabled)</label>
    </fieldset>
</div>

<div class="row">

    <h2>dijit.form.DateTextBox</h2>
    <br>

    <label for="date1">Enabled w/placeHolder:</label>
    <input id="date1" name="date1" type="text" data-dojo-type="dijit/form/DateTextBox" data-dojo-props="placeHolder:'Birthday'">
    <label for="date2">Disabled w/placeHolder:</label>
    <input id="date2" name="date2" type="text" data-dojo-type="dijit/form/DateTextBox" data-dojo-props='placeHolder:"Birthday", disabled:true'>
    <label for="date2">Disabled w/value:</label>
    <input id="date3" name="date3" type="text" data-dojo-type="dijit/form/DateTextBox" data-dojo-props='value:"2008-12-25", disabled:true'>

    <h2>dijit.form.TimeTextBox</h2>
    <label for="time1">Enabled:</label>
    <input id="time1" name="time1" type="text" data-dojo-type="dijit/form/TimeTextBox" value="T17:45:00">
    <label for="time2">Disabled:</label>
    <input id="time2" name="time2" type="text" data-dojo-type="dijit/form/TimeTextBox" value="T17:45:00"  data-dojo-props='disabled:true' disabled>

    <h2>dijit.form.CurrencyTextBox</h2>
    <label for="currency1">Enabled:</label>
    <input id="currency1" type="text" name="income1" value="54775.53" data-dojo-type="dijit/form/CurrencyTextBox"
           data-dojo-props="
                        required:true, constraints:{ fractional:true }, currency:'USD',
                        value:54775.53,
                        invalidMessage:'Invalid amount.	 Include dollar sign, commas, and cents.  Cents are mandatory.'
                ">
    <label for="currency2">Disabled:</label>
    <input id="currency2" type="text" name="income1" value="54775.53"
           data-dojo-type="dijit/form/CurrencyTextBox" data-dojo-props="required:true, constraints:{ fractional:true },
                        currency:'USD', invalidMessage:'Invalid amount.	 Include dollar sign, commas, and cents.  Cents are mandatory.',
                        disabled:true
                ">

    <h2>dijit.form.NumberSpinner max=100</h2>
    <label for="spinner1">Enabled: </label>
    <input data-dojo-type="dijit/form/NumberSpinner" data-dojo-props='constraints:{max:100,places:0}, value:10' id="spinner1">
    <label for="spinner2">Disabled: </label>
    <input data-dojo-type="dijit/form/NumberSpinner" data-dojo-props='constraints:{max:100,places:0}, value:10, disabled:true' id="spinner2">

</div>


<div class="row">
    <h2>dijit.form.Select</h2>
    <br/>
    <label>Enabled:</label>
    <div id="selectEnabled" data-dojo-type="dijit/form/Select" data-dojo-props="value:'AK'">
        <span data-dojo-value="AL"><b>Alabama</b></span>
        <span data-dojo-value="AK"><span style="color:red">A</span><span style="color:orange">l</span><span style="color:yellow">a</span><span style="color:green">s</span><span style="color:blue">k</span><span style="color:purple">a</span></span>
        <span data-dojo-value="AZ"><i>Arizona</i></span>
        <span data-dojo-value="AR"><span class="ark">Arkansas</span></span>
        <span data-dojo-value="CA"><span style="font-size:25%">C</span><span style="font-size:50%">a</span><span style="font-size:75%">l</span><span style="font-size:90%">i</span><span style="font-size:100%">f</span><span style="font-size:125%">o</span><span style="font-size:133%">r</span><span style="font-size:150%">n</span><span style="font-size:175%">i</span><span style="font-size:200%">a</span></span>
        <span data-dojo-value="NM">New<br>&nbsp;&nbsp;Mexico</span>
    </div>

    <label>Disabled: </label>
    <div id="selectDisabled" data-dojo-props="value:'AK', disabled:true" data-dojo-type="dijit/form/Select">
        <span data-dojo-value="AL"><b>Alabama</b></span>
        <span data-dojo-value="AK"><span style="color:red">A</span><span style="color:orange">l</span><span style="color:yellow">a</span><span style="color:green">s</span><span style="color:blue">k</span><span style="color:purple">a</span></span>
        <span data-dojo-value="AZ"><i>Arizona</i></span>
        <span data-dojo-value="AR"><span class="ark">Arkansas</span></span>
        <span data-dojo-value="CA"><span style="font-size:25%">C</span><span style="font-size:50%">a</span><span style="font-size:75%">l</span><span style="font-size:90%">i</span><span style="font-size:100%">f</span><span style="font-size:125%">o</span><span style="font-size:133%">r</span><span style="font-size:150%">n</span><span style="font-size:175%">i</span><span style="font-size:200%">a</span></span>
        <span data-dojo-value="NM">New<br>&nbsp;&nbsp;Mexico</span>
    </div>

</div>


<div class="row">
    <h2>dijit.form.FilteringSelect</h2>
    <label for="filteringSelect">Enabled w/placeHolder: </label>
    <input id="filteringSelect" data-dojo-type="dijit/form/FilteringSelect" data-dojo-props="
                ">
</div>


<div class="row">
    <h2>dijit.form.Textarea</h2>
    <textarea data-dojo-type="dijit/form/Textarea" data-dojo-props='name:"areText"' name="areText">This text area will expand and contract as you type &#8234;text.&#8236;

        Lorem ipsum dolor sit &#8234;amet,&#8236;
        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
    </textarea>

    <textarea data-dojo-type="dijit/form/SimpleTextarea">This text area has a constant height and displays a scrollbar when &#8234;necessary.&#8236;
    </textarea>

    <p>Disabled:</p>
    <textarea data-dojo-type="dijit/form/SimpleTextarea" data-dojo-props="disabled: true">Lorem ipsum dolor sit &#8234;amet,&#8236;
        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet
        dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci

    </textarea>
    <textarea data-dojo-type="dijit.form.Textarea" data-dojo-props="disabled: true">This text
        area is disabled and you shouldn't be able to type in &#8234;it.&#8236;
    </textarea>
</div>

<div class="row">
    <p>Enabled:</p>
    <!-- FIXME:
        set height on this node to size the whole editor, but causes the tab to not scroll
        until you select another tab and come back. alternative is no height: here, but that
        causes editor to become VERY tall, and size to a normal height when selected (like the
        dijit.form.TextArea in "Form Feel" Tab), but in reverse. refs #3980 and is maybe new bug?
    -->
    <div data-dojo-type="dijit/Editor" height="50px"></div>

    <p>Disabled:</p>
    <div data-dojo-type="dijit/Editor" height="35px">
        <ul>
            <li>Lorem <a href="http://dojotoolkit.org">and a link</a>, what do you think?</li>
            <li>This is the Editor with a Toolbar attached.</li>
        </ul>
    </div>
</div>

<div id="testb">
</div>

<code class="alert">注意：CI的flash机制也可以满足以上需求</code>