function MyObj(element)
{
    return document.getElementById(element);
}

function curry(fn, scope)
{
    var scope = scope || window;
    var args = Array.prototype.slice.call(arguments, 2) || [];

    return function()
    {
        fn.apply(scope, args);
    };
}

var rating = function(id, value)
{
    this.construct.apply(this, arguments);
};

rating.prototype =
{
    construct: function(id, stars, value, rerate, hinput)
    {
        this.id = id;
        this.imageOff = 'blank';
        this.imageOn = 'mouseOn';
        this.imageOut = 'mouseOff';
        this.stars = stars;
        this.rerate = rerate; 
        this.hinput = hinput;

        this.setValue(value);

        this.el = MyObj(id);
        	
        for(i=1; i<=this.stars; i++)
        {
            var starID = 'star'+this.id+i;
            var newstar = document.createElement('span');
            newstar.id = starID;
            newstar.className = this.imageOff;
			
            this.el.appendChild(newstar);
			
            this.addListener(MyObj(starID), "mouseover", curry(this.mouseOver, this, i));
            this.addListener(MyObj(starID), "click", curry(this.clickMethod, this, i));
        }

		this.addListener(this.el, "mouseout", curry(this.mouseOut, this));	

        this.renderStars(this.value, false);
    },
    
    addListener: function(element, type, expression, bubbling)
    {        
        bubbling = bubbling || false;
        
        if(window.addEventListener)
        {
          element.addEventListener(type, expression, bubbling);
          return true;
        }
        else if(window.attachEvent)
        {
            element.attachEvent('on' + type, expression);
            return true;
        }
        else 
        {
            return false;
        }
    },
    
    removeListener: function(element, type, expression, bubbling)
    {
        bubbling = bubbling || false;
        
        if(window.removeEventListener)
        {
          element.removeEventListener(type, expression, bubbling);
          return true;
        }
        else if(window.removeEvent)
        {
            element.removeEvent('on' + type, expression);
            return true;
        }
        else 
        {
            return false;
        }
    },

    mouseOver: function(rating)
    {
        if(this.rerate)
        {
            this.renderStars(rating, true);
        }
    },
	
    clickMethod: function(rating)
    {
        this.onClick(rating);
    },

    mouseOut: function()
    {
        if(this.rerate)
        {
            if(this.value == 0 || this.value == '')
            {
                this.renderStars(0, false);	
            }
            else
            {
                this.renderStars(this.value, false);
            }
        }
    },

    renderStars: function(units, startColor)
    {
        if(units > 0)
        {
            for(var i = 1; i <= units; i++)
            {
                if(startColor == true)
                {
                    MyObj("star" + this.id+i).className = this.imageOn;
                }
                else
                {
                    MyObj("star" +this.id+ i).className = this.imageOut;
                }
            }

            for (i = parseInt(units) + 1; i <= this.stars; i++)
            {
               MyObj("star" +this.id+i).className = this.imageOff;
            }
        }
        else
        {
            for (i = 1; i <= this.stars; i++)
            {
                MyObj("star"+this.id+i).className = this.imageOff;
            }
        }
    },

    onClick: function(value)
    {
        this.setValue(value);
        MyObj(this.hinput).value = this.value;

        if(!this.rerate)
        {
            for(i=1; i<=this.stars; i++)
            {
                this.removeListener(MyObj('star'+this.id+i), "mouseover");
                this.removeListener(MyObj('star'+this.id+i), "click");
            }
			
            this.removeListener(MyObj(this.id), "mouseout");
			
            this.renderStars(this.value, false);

        }
    },
	
    setValue: function(value)
    {
        this.value = value;
    },
	
    getValue: function()
    {
        return this.value;
    }
}