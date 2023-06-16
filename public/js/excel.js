    // active items only
    // let spread, sheet, cell = {};
    let cols = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    
    let spreads = [];

    let StyleType = {
        FontStyle : 0,
        FontSize : 1,
        HorizontalAlign : 2,
        VerticalAlign : 3,
        BackColor: 4,
        FontColor: 5,
        Format: 6,
        RowHeight: 7,
        ColWidth: 8
    },
    
    FontStyle = {
        Bold : 'bold',
        Italic : 'italic',
        Underline : 'underline'
    };
    

    function SetFontSize(cell, size)
    {
        var font = getFont(cell);
                
        var endIndex = font.indexOf("pt");
        if (endIndex == -1)
            endIndex = font.indexOf("px");
    			
        var startIndex = 0;
        for (startIndex = endIndex; startIndex >= 0; startIndex--)
            if (font[startIndex] == " ")
                break;
                
        font = font.substr(0, startIndex + 1) + size + font.substr(endIndex);
        cell.font(font);
    }
    
    function getFont(cell)
    {
        var font = cell.font();
        if (font == undefined)
            font = defaultFont;
    
        return font;
    }

    function GetFontSize(cell)
    {
        var font = getFont(cell);
                
        var endIndex = font.indexOf("pt");
        if (endIndex == -1)
            endIndex = font.indexOf("px");
    			
        var startIndex = 1;
        for (startIndex = endIndex; startIndex > 0; startIndex--)
        {
            if (font[startIndex] == " ")
            {
                startIndex++;
                break;
            }
        }
                
        var size = font.substr(startIndex, endIndex - startIndex);
        return size;
    }
    
    function isBold(cell)
    {
        return (getFont(cell).indexOf(FontStyle.Bold) == -1 ? false : true);
    }
            
    function isItalic(cell)
    {
        return (getFont(cell).indexOf(FontStyle.Italic) == -1 ? false : true);
    }
            
    function isUnderline(cell)
    {
        return (cell.textDecoration() == GcSpread.Sheets.TextDecorationType.Underline);
    }
            
    function SetBackColor(color, activeSheet)
    {
        var selectedRanges = activeSheet.getSelections();
        ApplyStyle(activeSheet, selectedRanges, StyleType.BackColor, color, true);
    }
            
    function SetFontColor(color, activeSheet)
    {
        var selectedRanges = activeSheet.getSelections();
        ApplyStyle(activeSheet, selectedRanges, StyleType.FontColor, color, true);
    }
            
    function SetFormat(format, activeSheet)
    {
        var selectedRanges = activeSheet.getSelections();
        ApplyStyle(activeSheet, selectedRanges, StyleType.Format, format, true);        
    }
            
    function SetFormulaBarValues(cell)
    {
        var selectedRow = cell.row;
        var selectedCol = cell.col;
                
        var formulabarposition = String.fromCharCode(65 + selectedCol).concat((selectedRow + 1));
        $("#formulabarposition").val(formulabarposition);
    }
            
    function UpdateToolbarButtonState(buttonName, enable)
    {
        if (enable)
            $(buttonName).addClass("state-active");
        else
            $(buttonName).removeClass("state-active");
            
    }
            
    function UpdateToolbar(args, activeSheet)
    {
        var row = args.row;
        var col = args.col;
        var cell = activeSheet.getCell(row, col);
                
        UpdateToolbarButtonState("#ButtonBold", isBold(cell));
        UpdateToolbarButtonState("#ButtonItalic", isItalic(cell));
        UpdateToolbarButtonState("#ButtonUnderline", isUnderline(cell));
                
        UpdateToolbarButtonState("#ButtonLeftAlign", (cell.hAlign() == GcSpread.Sheets.HorizontalAlign.left));
        UpdateToolbarButtonState("#ButtonCenterAlign", (cell.hAlign() == GcSpread.Sheets.HorizontalAlign.center));
        UpdateToolbarButtonState("#ButtonRightAlign", (cell.hAlign() == GcSpread.Sheets.HorizontalAlign.right));
                
        $("#SelectFontSize").val(GetFontSize(cell));
    }
    
    function GetStyleOfFirstColumn(sheet, selectedRanges, style)
    {
        var row = selectedRanges[0].row;
        var col = selectedRanges[0].col;
                
        var cell = sheet.getCell(row, col);
                
        if (style == FontStyle.Underline)
        {
            return cell.textDecoration() == GcSpread.Sheets.TextDecorationType.Underline;
        }
        else
        {
            var font = cell.font();
                    
            if (font == undefined)
                return false;
                        
            if (font.indexOf(style) == -1)
                return false;
            return true;
        }
    }
    
    
    function StyleCell(cell, style, enable)
    {
        if (style == FontStyle.Underline)
        {
            if (enable)
                cell.textDecoration(GcSpread.Sheets.TextDecorationType.Underline);
            else
                cell.textDecoration("");
        }
        else if (style == FontStyle.Bold || style == FontStyle.Italic)
        {
            var font = getFont(cell);
                    
            if (enable)
            {
                if (font.indexOf(style) == -1)
                    font = style.concat(" ").concat(font);
            }
            else
                font = font.replace (style, "").trim();
            cell.font(font);
        }
    }
                    
    
    function ApplyStyle(sheet, selectedRanges, styleType, styleValue, enable)
    {           
        for(var sel = 0; sel < selectedRanges.length; sel++)
        {
            var rowStart = selectedRanges[sel].row;
            var colStart = selectedRanges[sel].col;
            var rowCount = selectedRanges[sel].rowCount;
            var colCount = selectedRanges[sel].colCount;
                    
            for(var i = rowStart; i < rowCount + rowStart; i++)
            {
                for(var j = colStart; j < colCount + colStart; j++)
                {
                    var cell = sheet.getCell(i, j);
                    switch (styleType)
                    {
                        case StyleType.FontStyle:
                            StyleCell(cell, styleValue, enable);
                            UpdateToolbar(cell, sheet);
                            break;
                                    
                        case StyleType.FontSize:
                            SetFontSize(cell, styleValue);
                            UpdateToolbar(cell, sheet);
                            break;
                                    
                        case StyleType.HorizontalAlign:
                            cell.hAlign(styleValue);
                            UpdateToolbar(cell, sheet);
                            break;
    
                        case StyleType.VerticalAlign:
                            cell.vAlign(styleValue);
                            UpdateToolbar(cell, sheet);
                            break;
    
                        case StyleType.BackColor:
                            cell.backColor(styleValue);
                            break;
                                    
                        case StyleType.FontColor:
                            cell.foreColor(styleValue);
                            break;
                                    
                        case StyleType.Format:
                            cell.formatter(styleValue);
                            break;
    								
                        case StyleType.RowHeight:
                            sheet.setRowHeight(i, styleValue);
                            break;
    								
                        case StyleType.ColWidth:
                            sheet.setColumnWidth(j, styleValue);
                            break;
                    }
                }
            }
        }
    }
    
    function excel_init(){
        
        setTimeout(_=>{
        
        $('.excel-editor').each(function(i,v){
            
            let container = $(v);
            
            let colorPickerHtml = `
            
                <div class="sp-palette-container">
                    <div class="sp-palette sp-thumb sp-cf">
                        <div class="sp-cf sp-palette-row sp-palette-row-0"><span title="rgb(0, 0, 0)" data-color="rgb(0, 0, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(0, 0, 0);"></span></span><span title="rgb(68, 68, 68)" data-color="rgb(68, 68, 68)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(68, 68, 68);"></span></span><span title="rgb(102, 102, 102)" data-color="rgb(102, 102, 102)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(102, 102, 102);"></span></span><span title="rgb(153, 153, 153)" data-color="rgb(153, 153, 153)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(153, 153, 153);"></span></span><span title="rgb(204, 204, 204)" data-color="rgb(204, 204, 204)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(204, 204, 204);"></span></span><span title="rgb(238, 238, 238)" data-color="rgb(238, 238, 238)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(238, 238, 238);"></span></span><span title="rgb(243, 243, 243)" data-color="rgb(243, 243, 243)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(243, 243, 243);"></span></span><span title="rgb(255, 255, 255)" data-color="rgb(255, 255, 255)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 255, 255);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-1"><span title="rgb(255, 0, 0)" data-color="rgb(255, 0, 0)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 0, 0);"></span></span><span title="rgb(255, 153, 0)" data-color="rgb(255, 153, 0)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 153, 0);"></span></span><span title="rgb(255, 255, 0)" data-color="rgb(255, 255, 0)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 255, 0);"></span></span><span title="rgb(0, 255, 0)" data-color="rgb(0, 255, 0)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(0, 255, 0);"></span></span><span title="rgb(0, 255, 255)" data-color="rgb(0, 255, 255)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(0, 255, 255);"></span></span><span title="rgb(0, 0, 255)" data-color="rgb(0, 0, 255)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(0, 0, 255);"></span></span><span title="rgb(153, 0, 255)" data-color="rgb(153, 0, 255)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(153, 0, 255);"></span></span><span title="rgb(255, 0, 255)" data-color="rgb(255, 0, 255)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 0, 255);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-2"><span title="rgb(244, 204, 204)" data-color="rgb(244, 204, 204)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(244, 204, 204);"></span></span><span title="rgb(252, 229, 205)" data-color="rgb(252, 229, 205)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(252, 229, 205);"></span></span><span title="rgb(255, 242, 204)" data-color="rgb(255, 242, 204)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 242, 204);"></span></span><span title="rgb(217, 234, 211)" data-color="rgb(217, 234, 211)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(217, 234, 211);"></span></span><span title="rgb(208, 224, 227)" data-color="rgb(208, 224, 227)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(208, 224, 227);"></span></span><span title="rgb(207, 226, 243)" data-color="rgb(207, 226, 243)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(207, 226, 243);"></span></span><span title="rgb(217, 210, 233)" data-color="rgb(217, 210, 233)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(217, 210, 233);"></span></span><span title="rgb(234, 209, 220)" data-color="rgb(234, 209, 220)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(234, 209, 220);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-3"><span title="rgb(234, 153, 153)" data-color="rgb(234, 153, 153)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(234, 153, 153);"></span></span><span title="rgb(249, 203, 156)" data-color="rgb(249, 203, 156)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(249, 203, 156);"></span></span><span title="rgb(255, 229, 153)" data-color="rgb(255, 229, 153)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 229, 153);"></span></span><span title="rgb(182, 215, 168)" data-color="rgb(182, 215, 168)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(182, 215, 168);"></span></span><span title="rgb(162, 196, 201)" data-color="rgb(162, 196, 201)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(162, 196, 201);"></span></span><span title="rgb(159, 197, 232)" data-color="rgb(159, 197, 232)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(159, 197, 232);"></span></span><span title="rgb(180, 167, 214)" data-color="rgb(180, 167, 214)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(180, 167, 214);"></span></span><span title="rgb(213, 166, 189)" data-color="rgb(213, 166, 189)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(213, 166, 189);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-4"><span title="rgb(224, 102, 102)" data-color="rgb(224, 102, 102)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(224, 102, 102);"></span></span><span title="rgb(246, 178, 107)" data-color="rgb(246, 178, 107)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(246, 178, 107);"></span></span><span title="rgb(255, 217, 102)" data-color="rgb(255, 217, 102)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(255, 217, 102);"></span></span><span title="rgb(147, 196, 125)" data-color="rgb(147, 196, 125)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(147, 196, 125);"></span></span><span title="rgb(118, 165, 175)" data-color="rgb(118, 165, 175)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(118, 165, 175);"></span></span><span title="rgb(111, 168, 220)" data-color="rgb(111, 168, 220)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(111, 168, 220);"></span></span><span title="rgb(142, 124, 195)" data-color="rgb(142, 124, 195)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(142, 124, 195);"></span></span><span title="rgb(194, 123, 160)" data-color="rgb(194, 123, 160)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(194, 123, 160);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-5"><span title="rgb(204, 0, 0)" data-color="rgb(204, 0, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(204, 0, 0);"></span></span><span title="rgb(230, 145, 56)" data-color="rgb(230, 145, 56)" class="sp-thumb-el sp-thumb-light sp-thumb-active"><span class="sp-thumb-inner" style="background-color:rgb(230, 145, 56);"></span></span><span title="rgb(241, 194, 50)" data-color="rgb(241, 194, 50)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(241, 194, 50);"></span></span><span title="rgb(106, 168, 79)" data-color="rgb(106, 168, 79)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(106, 168, 79);"></span></span><span title="rgb(69, 129, 142)" data-color="rgb(69, 129, 142)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(69, 129, 142);"></span></span><span title="rgb(61, 133, 198)" data-color="rgb(61, 133, 198)" class="sp-thumb-el sp-thumb-light"><span class="sp-thumb-inner" style="background-color:rgb(61, 133, 198);"></span></span><span title="rgb(103, 78, 167)" data-color="rgb(103, 78, 167)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(103, 78, 167);"></span></span><span title="rgb(166, 77, 121)" data-color="rgb(166, 77, 121)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(166, 77, 121);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-6"><span title="rgb(153, 0, 0)" data-color="rgb(153, 0, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(153, 0, 0);"></span></span><span title="rgb(180, 95, 6)" data-color="rgb(180, 95, 6)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(180, 95, 6);"></span></span><span title="rgb(191, 144, 0)" data-color="rgb(191, 144, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(191, 144, 0);"></span></span><span title="rgb(56, 118, 29)" data-color="rgb(56, 118, 29)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(56, 118, 29);"></span></span><span title="rgb(19, 79, 92)" data-color="rgb(19, 79, 92)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(19, 79, 92);"></span></span><span title="rgb(11, 83, 148)" data-color="rgb(11, 83, 148)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(11, 83, 148);"></span></span><span title="rgb(53, 28, 117)" data-color="rgb(53, 28, 117)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(53, 28, 117);"></span></span><span title="rgb(116, 27, 71)" data-color="rgb(116, 27, 71)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(116, 27, 71);"></span></span>
                        </div>
                        <div class="sp-cf sp-palette-row sp-palette-row-7"><span title="rgb(102, 0, 0)" data-color="rgb(102, 0, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(102, 0, 0);"></span></span><span title="rgb(120, 63, 4)" data-color="rgb(120, 63, 4)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(120, 63, 4);"></span></span><span title="rgb(127, 96, 0)" data-color="rgb(127, 96, 0)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(127, 96, 0);"></span></span><span title="rgb(39, 78, 19)" data-color="rgb(39, 78, 19)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(39, 78, 19);"></span></span><span title="rgb(12, 52, 61)" data-color="rgb(12, 52, 61)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(12, 52, 61);"></span></span><span title="rgb(7, 55, 99)" data-color="rgb(7, 55, 99)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(7, 55, 99);"></span></span><span title="rgb(32, 18, 77)" data-color="rgb(32, 18, 77)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(32, 18, 77);"></span></span><span title="rgb(76, 17, 48)" data-color="rgb(76, 17, 48)" class="sp-thumb-el sp-thumb-dark"><span class="sp-thumb-inner" style="background-color:rgb(76, 17, 48);"></span></span>
                        </div>
                    </div>
                </div>
                
            `;
            
            container.find('.excel-element').addClass('hidden').after(`
                <div style="width: 100%; display: block; background-color: #F1F1F1;" class="_menu">
                    <nav class="navbar border-radius-0 transparent-bg" role="navigation" aria-label="main navigation">
                        <div id="navbarBasicExample" class="navbar-menu">
                            <div class="navbar-start">
                            
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless">
                                    Edit
                                    </a>    
                                
                                    <div class="navbar-dropdown min-width-200">
                                        <a class="navbar-item">
                                            <span class="undo">Undo</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+Z</small>
                                        </a>
                                        <a class="navbar-item">
                                            <span class="redo">Redo</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+Y</small>
                                        </a>
                                        
                                        <hr class="navbar-divider">
                                        
                                        <a class="navbar-item">
                                            <span class="cut">Cut</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+X</small>
                                        </a>
                                        <a class="navbar-item">
                                            <span class="copy">Copy</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+C</small>
                                        </a>
                                        <a class="navbar-item">
                                            <span class="paste">Paste</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+V</small>
                                        </a>
                                        <a class="navbar-item">
                                            <span class="pasteSpecial">Paste Special...</span>
                                        </a>
                                        <a class="navbar-item">
                                            <span class="copyFormat">Copy Cell Format</span>
                                        </a>
                                        
                                        <hr class="navbar-divider">
                                        
                                        <a class="navbar-item">
                                        Find
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+F</small>
                                        </a>
                                        
                                        <a class="navbar-item">
                                        Replace
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+HV</small>
                                        </a>
                                        
                                        <hr class="navbar-divider">
                                        
                                        <a class="navbar-item">
                                            <span class="select-all">Select All</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+A</small>
                                        </a>
                                        
                                    </div>
                                </div>
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless">
                                    Format
                                    </a>    
                                
                                    <div class="navbar-dropdown" style="width: 160px;">
                                    
                                        <a class="navbar-item ">
                                        Cells...
                                        </a>
                                    
                                        <hr class="navbar-divider">
                                    
                                        <a class="navbar-item ">
                                        <span class="bold">Bold</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+B</small>
                                        </a>
                                        <a class="navbar-item">
                                        <span class="italic">Italic</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+I</small>
                                        </a>
                                        <a class="navbar-item">
                                        <span class="underline">Underline</span>
                                            <small class="is-pulled-right gray-text font-size-10 margin-right-10">Ctrl+U</small>
                                        </a>
                                        
                                        <hr class="navbar-divider">
                                        
                                        <a class="navbar-item ">
                                            <span class="row-height">Row Height</span>
                                        </a>
                                        <a class="navbar-item ">
                                            <span class="col-width">Column Width</span>
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                    
            <div class="spreadsheet-toolbar">
                        <!-- Sample menu buttons taken from tinyMCE toolbar -->
                        <div class="" role="toolbar">
                            <button class="reset"></button>
                            <button class="cut" ></button>
                            <button class="copy" ></button>
                            <button class="paste" ></button>
                            <button class="copyformat" ></button>
                            <button class="undo" ></button>
                            <button class="redo" ></button>
                            <select class="zoom">
                                <option value="25">25%</option>
                                <option value="50">50%</option>
                                <option value="75">75%</option>
                                <option selected="" value="100">100%</option>
                                <option value="200">200%</option>
                            </select>
                        </div>
                        <div class="" role="toolbar">
                            <select class="fontsize">
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option selected="">13</option>
                                <option>14</option>
                                <option>18</option>
                                <option>20</option>
                                <option>22</option>
                                <option>24</option>
                                <option>26</option>
                                <option>28</option>
                                <option>36</option>
                                <option>48</option>
                                <option>72</option>\
                            </select>
            
                            <button class="bold" data-command="bold"></button>
                            <button class="italic" data-command="italic"></button>
                            <button class="underline" data-command="underline"></button>
                            <button class="fontcolor"></button>
                            <button class="fillcolor"></button>
            
                            <button class="align-left left" data-command="hAlign" data-param="left"></button>
                            <button class="align-center center" data-command="hAlign" data-param="center"></button>
                            <button class="align-right right" data-command="hAlign" data-param="right"></button>
            
                            <button class="number dropdown" data-command="_number"></button>
                            <button class="currency dropdown" data-command="_currency"></button>
                            <button class="percent dropdown" data-command="_percent"></button>
                            <button class="fraction dropdown" data-command="_fraction"></button>
                            <button class="datetime dropdown" data-command="_datetime"></button>
            
                        </div>
                    </div>
                    
                    <div class="contextmenus" style="position: relative;">
                    
                        <ul class="numberMenu ui-contextmenu ui-menu ui-widget ui-widget-content" style="display: none; position: absolute; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); background-color: #ffffff; padding: 10px 20px; ">
                            <li data-command="format" data-param="General" class="ui-menu-item" ><a href="javascript:void(0)" class="">General</a></li>
                            <li data-command="_cells" data-param="custom" class="ui-menu-item" ><a href="javascript:void(0)" class="custom">Custom</a></li>
                            <li data-command="format" data-param="0.00" class="ui-menu-item" ><a href="javascript:void(0)" class="">0.00</a></li>
                            <li data-command="format" data-param="#,##0" class="ui-menu-item" ><a href="javascript:void(0)" class="">#,##0</a></li>
                            <li data-command="format" data-param="#,##0.00" class="ui-menu-item" ><a href="javascript:void(0)" class="">#,##0.00</a></li>
                        </ul>
                        
                        <ul class="currencyMenu ui-contextmenu context-menu-list context-menu-root" style="width: 280px; z-index: 1; display: none; position: absolute;  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); background-color: #ffffff; padding: 10px 20px;">
                            <li class="context-menu-item"><span>General</span></li>
                            <li class="context-menu-item"><span>Custom</span></li>
                            <li class="context-menu-item"><span>$#,##0;[Red]($#,##0)</span></li>
                            <li class="context-menu-item"><span>$#,##0.00;($#,##0.00)</span></li>
                            <li class="context-menu-item"><span>$#,##0.00;[Red]($#,##0.00)</span></li>
                            <li class="context-menu-item"><span>#,##0;(#,##0)</span></li>
                            <li class="context-menu-item"><span>#,##0;[Red](#,##0)</span></li>
                            <li class="context-menu-item"><span>#,##0.00;(#,##0.00)</span></li>
                            <li class="context-menu-item"><span>#,##0.00;[Red](#,##0.00)</span></li>
                            <li class="context-menu-item"><span>_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)</span></li>
                            <li class="context-menu-item"><span>_($* #,##0_);_($* (#,##0);_($* "-"_);_(@_)</span></li>
                            <li class="context-menu-item"><span>_(* #,##0.00_);_(* (#,##0.00);_(* "-&amp;"??_);_(@_)</span></li>
                            <li class="context-menu-item"><span>_($* #,##0.00_);_($* (#,##0.00);_($* "-"??_);_(@_)</span></li>
                        </ul>
                        
                        <ul class="percentMenu ui-contextmenu ui-menu ui-widget ui-widget-content" style="display: none; position: absolute;  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); background-color: #ffffff; padding: 10px 20px;" role="menu" tabindex="0" aria-activedescendant="ui-id-33">
                            <li data-command="format" data-param="0%" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">0%</a></li>
                            <li data-command="format" data-param="0.00%" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">0.00%</a></li>
                            <li data-command="format" data-param="0.0%" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">0.0%</a></li>
                        </ul>
                        
                        <ul class="fractionMenu ui-contextmenu ui-menu ui-widget ui-widget-content" style="display: none; position: absolute; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); background-color: #ffffff; padding: 10px 20px;" role="menu" tabindex="0" aria-activedescendant="ui-id-37">
                            <li data-command="format" data-param="# ?/?" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class=""># ?/?</a></li>
                            <li data-command="format" data-param="# ??/??" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class=""># ??/??</a></li>
                        </ul>
                        
                        <ul class="datetimeMenu ui-contextmenu ui-menu ui-widget ui-widget-content" style="padding-right: 10px; display: none; position: absolute;  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); background-color: #ffffff; padding: 10px 20px;" role="menu" tabindex="0" aria-activedescendant="ui-id-43">
                            <li data-param="m/d/yyyy" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">m/d/yyyy</a></li>
                            <li data-param="d-mmm-yy" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">d-mmm-yy</a></li>
                            <li data-param="d-mmm" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">d-mmm</a></li>
                            <li data-param="mmm-yy" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">mmm-yy</a></li>
                            <li data-param="h:mm AM/PM" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">h:mm AM/PM</a></li>
                            <li data-param="h:mm:ss AM/PM" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">h:mm:ss AM/PM</a></li>
                            <li data-param="h:mm" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">h:mm</a></li>
                            <li data-param="h:mm:ss" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">h:mm:ss</a></li>
                            <li data-param="m/d/yyyy h:mm" class="ui-menu-item" tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">m/d/yyyy h:mm</a></li>
                            <li data-param="mm:ss" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">mm:ss</a></li>
                            <li data-param="[h]:mm:ss" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">[h]:mm:ss</a></li>
                            <li data-param="mm:ss.0" class="ui-menu-item"  tabindex="-1" role="menuitem"><a href="javascript:void(0)" class="">mm:ss.0</a></li>
                        </ul>
                    
                    </div>
                    
                    <div class="ui-contextmenu color-platter text-color-picker" style="display: none;"> <div class="sp-container sp-light sp-input-disabled sp-clear-enabled sp-palette-buttons-disabled sp-palette-only sp-initial-disabled" style="position: absolute; top: 0px; left: 130px; padding: 10px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);">`+colorPickerHtml+`</div></div>
                    <div class="ui-contextmenu color-platter background-color-picker" style="display: none;"><div class="sp-container sp-light sp-input-disabled sp-clear-enabled sp-palette-buttons-disabled sp-palette-only sp-initial-disabled" style="position: absolute; top: 0px; left: 160px; padding: 10px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);">`+colorPickerHtml+`</div></div>
                    
                    <table class="formulaBar" style="width: 100%; ">
                        <tbody>
                            <tr>
                                <td style="width: 100px; border-color:#ABABAB;">
                                    <input type="text" class="selected-cell font-size-12" disabled="disabled" style="text-align: center; height: 23px;margin: 0;">
                                </td>
                                <td>
                                    <div class="selected-value font-size-12" contenteditable="true" spellcheck="false" style="background-color: #ffffff; line-height: 16px;border: 1px solid #ABABAB; overflow: hidden; padding: 3px; height: 23px;margin: 0;"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="testForm" contenteditable="true" spellcheck="false"></div>
                    
                </div>
                <div style="width: 100%; height: 500px; width: 575px; display: block; background-color: white;" class="_sheet"></div>
            `);
            
            // Make menu
            let _menu = $(container).find('._menu')[0],
                _sheet = $(container).find('._sheet')[0],
                spread, sheet, cell = {y: 0, x: 0}, range,
                selected_cell = container.find('.selected-cell').first(),
                json_data = null;
            // End: make menu

            

            setTimeout(_=>{

                if (container.find('[q-type="excel"]').val() ){
                    if (container.find('[q-type="excel"]').val().length > 2) {
                        json_data = container.find('[q-type="excel"]').val();
                    }
                }
                
                // Initialize
                spread = new GcSpread.Sheets.Spread( _sheet , { sheetCount: 1 });
                spread.allowUndo(true);
                spread.tabStripVisible(false);
                sheet = spread.getActiveSheet();
                sheet.isPaintSuspended(false);
                sheet.setRowCount(100);
                sheet.setColumnCount(26);
                sheet.allowCellOverflow(true);
                sheet.setGridlineOptions({ color: '#9eb6cc' });
                sheet.fromJSON(JSON.parse(json_data));
                range = sheet.getSelections();
                // END: Initialize

                spreads.push( spread );
                
                // Enable formula box
                var a = new GcSpread.Sheets.FormulaTextBox( container.find(".selected-value").get(0) );
                a.autoComplete(true);
                a.spread(spread);
                
                selected_cell.val("A1");
                // END: Enable formula box
                

                sheet.bind(GcSpread.Sheets.Events.EnterCell, function (e, i) {
            
                    cell.x = i.col;
                    cell.y = i.row;
                    cell.name = cols[i.col]+(i.row*1+1);
                    cell.value = sheet.getCell(cell.y, cell.x).value();
                    
                    selected_cell.val(cell.name);
                
                });
                
                sheet.bind( GcSpread.Sheets.Events.CellChanged, function (e, i) {
                    
                    container.find('textarea.excel-element').val( JSON.stringify(sheet.toJSON()) );
                    
                });
                
                $('body').click(function(e){ if(!$(e.target).closest('.ui-contextmenu').length && !$(e.target).closest('.spreadsheet-toolbar button').length) $(".ui-contextmenu").hide(); })
                
                container.find('.spreadsheet-toolbar button, .navbar-item span, .spreadsheet-toolbar select').on('click change',function(e){
                    
                    e.preventDefault();
                    
                    let input = $(this), v = input.val();
                        range = sheet.getSelections();
                        
                    switch( input.attr('class') ){
                        
                        case 'reset':
                                sheet.reset();
                                break;
                        
                        case 'undo':
                                GcSpread.Sheets.SpreadActions.undo.apply(sheet);
                                break;
                        
                        case 'redo':
                                GcSpread.Sheets.SpreadActions.redo.apply(sheet);
                                break;
                        
                        case 'select-all':
                                var rowCount = sheet.getRowCount();
                                var colCount = sheet.getColumnCount();
                                sheet.addSelection(0, 0, rowCount, colCount);
                                break;
                        
                        case 'copyformat':
                                fromRange = sheet.getSelections()[0];
                                isCopyFormat = true;
                                isCutting = false;    
                                break;
                        
                        case 'copy':
                                fromRange = sheet.getSelections()[0];
                                isCutting = false;      
                                break;
                        
                        case 'cut':
                                fromRange = sheet.getSelections()[0];
                                isCutting = true;
                                break;
                        
                        case 'paste':
                                var toRanges = sheet.getSelections();
                                var clipboardCopyPasteAction = new GcSpread.Sheets.UndoRedo.ClipboardPasteUndoAction(sheet, sheet, sheet, { fromRange: fromRange, pastedRanges: toRanges, isCutting: isCutting, clipboardText: "" }, GcSpread.Sheets.ClipboardPasteOptions.All);
                                clipboardCopyPasteAction.execute(sheet);
                                break;
                        
                        case 'row-height':
                                var selectedRanges = sheet.getSelections();
                                var rowHeightValue = 20;
                                if ($("#optRowHeightCustom").is(":checked"))
                                    rowHeightValue = $("#txtRowHeight").val();
                                ApplyStyle(sheet, selectedRanges, StyleType.RowHeight, rowHeightValue, true);
                                break;
                        
                        case 'col-width':
                                var selectedRanges = sheet.getSelections();
                                var colWidthValue = 60;
                                if ($("#optColWidthCustom").is(":checked"))
                                    colWidthValue = $("#txtColWidth").val();
                                ApplyStyle(sheet, selectedRanges, StyleType.ColWidth, colWidthValue, true);
                                break;
            
                        case 'zoom': 
                            sheet.zoom( v / 100.0);
                            sheet.isPaintSuspended(false);
                            sheet.repaint();
                            break;
                            
                        case 'fontsize':
                            ApplyStyle(sheet, range, StyleType.FontSize, v, true);
                            break;
                            
                        case 'bold':
                            var enable = GetStyleOfFirstColumn(sheet, range, FontStyle.Bold);
                            ApplyStyle(sheet, range, StyleType.FontStyle, FontStyle.Bold, !enable);
                            break;
                            
                        case 'underline':
                            var enable = GetStyleOfFirstColumn(sheet, range, FontStyle.Underline);
                            ApplyStyle(sheet, range, StyleType.FontStyle, FontStyle.Underline, !enable);
                            break;
                            
                        case 'italic':
                            var enable = GetStyleOfFirstColumn(sheet, range, FontStyle.Italic);
                            ApplyStyle(sheet, range, StyleType.FontStyle, FontStyle.Italic, !enable);
                            break;
                            
                        case 'align-left left':
                            ApplyStyle(sheet, range, StyleType.HorizontalAlign, GcSpread.Sheets.HorizontalAlign.left, true);
                            break;
                            
                        case 'align-center center':
                            ApplyStyle(sheet, range, StyleType.HorizontalAlign, GcSpread.Sheets.HorizontalAlign.center, true);
                            break;
                            
                        case 'align-right right':
                            ApplyStyle(sheet, range, StyleType.HorizontalAlign, GcSpread.Sheets.HorizontalAlign.right, true);
                            break;
                            
                        case 'number dropdown':
                            container.find('.ui-contextmenu').hide();
                            container.find('.numberMenu').show().css({'top': (e.pageY-$(input).offset().top-10)+'px', 'left': '280px'});
                            break;
                            
                        case 'currency dropdown':
                            container.find('.ui-contextmenu').hide();
                            container.find('.currencyMenu').show().css({'top': (e.pageY-$(input).offset().top-10)+'px', 'left': '288px'});
                            break;
                            
                        case 'percent dropdown':
                            container.find('.ui-contextmenu').hide();
                            container.find('.percentMenu').show().css({'top': (e.pageY-$(input).offset().top-10)+'px', 'left': '326px'});
                            break;
                            
                        case 'fraction dropdown':
                            container.find('.ui-contextmenu').hide();
                            container.find('.fractionMenu').show().css({'top': (e.pageY-$(input).offset().top-10)+'px', 'left': '338px'});
                            break;
                            
                        case 'datetime dropdown':
                            container.find('.ui-contextmenu').hide();
                            container.find('.datetimeMenu').show().css({'top': (e.pageY-$(input).offset().top-10)+'px', 'left': '380px'});
                            break;
                            
                        case 'fontcolor':
                            container.find('.ui-contextmenu').hide();
                            container.find('.text-color-picker').show();
                            break;
                            
                        case 'fillcolor':
                            container.find('.ui-contextmenu').hide();
                            container.find('.background-color-picker').show();
                            break;

                        
                    }
                    
                    
                })
                
                
                container.find('.contextmenus li').click(function(e){ SetFormat( $(this).text().trim(), sheet ); })
                
                container.find('.sp-thumb-inner').click(function(e){ 
                    
                    let selected = $(this),
                        color = selected.parent().data('color')
                        holder = selected.parents('.sp-palette');
                        
                    holder.find('.sp-thumb-inner').removeClass('selected');
                    
                    selected.addClass('selected');
                    
                    if( $(this).parents('.text-color-picker').length > 0 ){
                        
                        SetFontColor( color, sheet);   
                        
                    } else if( $(this).parents('.background-color-picker').length > 0 ){
                        
                        SetBackColor(color, sheet);
                    }
                        
                    
                })
                
                
            },1000)
            
        
        })
        
        }, 500);
        
    }