/* ===================================================
 *  jquery-sortable.js v0.9.13
 *  http://johnny.github.com/jquery-sortable/
 * ===================================================
 *  Copyright (c) 2012 Jonas von Andrian
 *  All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *  * The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 *  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 *  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *  DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 *  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 *  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 *  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 *  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * ========================================================== */


!function ( $, window, pluginName, undefined){
  var containerDefaults = {
    // If true, items can be dragged from this container
    drag: true,
    // If true, items can be droped onto this container
    drop: true,
    // Exclude items from being draggable, if the
    // selector matches the item
    exclude: "",
    // If true, search for nested containers within an item.If you nest containers,
    // either the original selector with which you call the plugin must only match the top containers,
    // or you need to specify a group (see the bootstrap nav example)
    nested: true,
    // If true, the items are assumed to be arranged vertically
    vertical: true
  }, // end container defaults
  groupDefaults = {
    // This is executed after the placeholder has been moved.
    // $closestItemOrContainer contains the closest item, the placeholder
    // has been put at or the closest empty Container, the placeholder has
    // been appended to.
    afterMove: function ($placeholder, container, $closestItemOrContainer) {
    },
    // The exact css path between the container and its items, e.g. "> tbody"
    containerPath: "",
    // The css selector of the containers
    containerSelector: "ol, ul",
    // Distance the mouse has to travel to start dragging
    distance: 0,
    // Time in milliseconds after mousedown until dragging should start.
    // This option can be used to prevent unwanted drags when clicking on an element.
    delay: 0,
    // The css selector of the drag handle
    handle: "",
    // The exact css path between the item and its subcontainers.
    // It should only match the immediate items of a container.
    // No item of a subcontainer should be matched. E.g. for ol>div>li the itemPath is "> div"
    itemPath: "",
    // The css selector of the items
    itemSelector: "li",
    // The class given to "body" while an item is being dragged
    bodyClass: "dragging",
    // The class giving to an item while being dragged
    draggedClass: "dragged",
    // Check if the dragged item may be inside the container.
    // Use with care, since the search for a valid container entails a depth first search
    // and may be quite expensive.
    isValidTarget: function ($item, container) {
      return true
    },
    // Executed before onDrop if placeholder is detached.
    // This happens if pullPlaceholder is set to false and the drop occurs outside a container.
    onCancel: function ($item, container, _super, event) {
    },
    // Executed at the beginning of a mouse move event.
    // The Placeholder has not been moved yet.
    onDrag: function ($item, position, _super, event) {
      $item.css(position)
    },
    // Called after the drag has been started,
    // that is the mouse button is being held down and
    // the mouse is moving.
    // The container is the closest initialized container.
    // Therefore it might not be the container, that actually contains the item.
    onDragStart: function ($item, container, _super, event) {
      $item.css({
        height: $item.outerHeight(),
        width: $item.outerWidth()
      })
      $item.addClass(container.group.options.draggedClass)
      $("body").addClass(container.group.options.bodyClass)
    },
    // Called when the mouse button is being released
    onDrop: function ($item, container, _super, event) {
      $item.removeClass(container.group.options.draggedClass).removeAttr("style")
      $("body").removeClass(container.group.options.bodyClass)
    },
    // Called on mousedown. If falsy value is returned, the dragging will not start.
    // Ignore if element clicked is input, select or textarea
    onMousedown: function ($item, _super, event) {
      if (!event.target.nodeName.match(/^(input|select|textarea)$/i)) {
        event.preventDefault()
        return true
      }
    },
    // The class of the placeholder (must match placeholder option markup)
    placeholderClass: "placeholder",
    // Template for the placeholder. Can be any valid jQuery input
    // e.g. a string, a DOM element.
    // The placeholder must have the class "placeholder"
    placeholder: '<li class="placeholder"></li>',
    // If true, the position of the placeholder is calculated on every mousemove.
    // If false, it is only calculated when the mouse is above a container.
    pullPlaceholder: true,
    // Specifies serialization of the container group.
    // The pair $parent/$children is either container/items or item/subcontainers.
    serialize: function ($parent, $children, parentIsContainer) {
      var result = $.extend({}, $parent.data())

      if(parentIsContainer)
        return [$children]
      else if ($children[0]){
        result.children = $children
      }

      delete result.subContainers
      delete result.sortable

      return result
    },
    // Set tolerance while dragging. Positive values decrease sensitivity,
    // negative values increase it.
    tolerance: 0
  }, // end group defaults
  containerGroups = {},
  groupCounter = 0,
  emptyBox = {
    left: 0,
    top: 0,
    bottom: 0,
    right:0
  },
  eventNames = {
    start: "touchstart.sortable mousedown.sortable",
    drop: "touchend.sortable touchcancel.sortable mouseup.sortable",
    drag: "touchmove.sortable mousemove.sortable",
    scroll: "scroll.sortable"
  },
  subContainerKey = "subContainers"

  /*
   * a is Array [left, right, top, bottom]
   * b is array [left, top]
   */
  function d(a,b) {
    var x = Math.max(0, a[0] - b[0], b[0] - a[1]),
    y = Math.max(0, a[2] - b[1], b[1] - a[3])
    return x+y;
  }

  function setDimensions(array, dimensions, tolerance, useOffset) {
    var i = array.length,
    offsetMethod = useOffset ? "offset" : "position"
    tolerance = tolerance || 0

    while(i--){
      var el = array[i].el ? array[i].el : $(array[i]),
      // use fitting method
      pos = el[offsetMethod]()
      pos.left += parseInt(el.css('margin-left'), 10)
      pos.top += parseInt(el.css('margin-top'),10)
      dimensions[i] = [
        pos.left - tolerance,
        pos.left + el.outerWidth() + tolerance,
        pos.top - tolerance,
        pos.top + el.outerHeight() + tolerance
      ]
    }
  }

  function getRelativePosition(pointer, element) {
    var offset = element.offset()
    return {
      left: pointer.left - offset.left,
      top: pointer.top - offset.top
    }
  }

  function sortByDistanceDesc(dimensions, pointer, lastPointer) {
    pointer = [pointer.left, pointer.top]
    lastPointer = lastPointer && [lastPointer.left, lastPointer.top]

    var dim,
    i = dimensions.length,
    distances = []

    while(i--){
      dim = dimensions[i]
      distances[i] = [i,d(dim,pointer), lastPointer && d(dim, lastPointer)]
    }
    distances = distances.sort(function  (a,b) {
      return b[1] - a[1] || b[2] - a[2] || b[0] - a[0]
    })

    // last entry is the closest
    return distances
  }

  function ContainerGroup(options) {
    this.options = $.extend({}, groupDefaults, options)
    this.containers = []

    if(!this.options.rootGroup){
      this.scrollProxy = $.proxy(this.scroll, this)
      this.dragProxy = $.proxy(this.drag, this)
      this.dropProxy = $.proxy(this.drop, this)
      this.placeholder = $(this.options.placeholder)

      if(!options.isValidTarget)
        this.options.isValidTarget = undefined
    }
  }

  ContainerGroup.get = function  (options) {
    if(!containerGroups[options.group]) {
      if(options.group === undefined)
        options.group = groupCounter ++

      containerGroups[options.group] = new ContainerGroup(options)
    }

    return containerGroups[options.group]
  }

  ContainerGroup.prototype = {
    dragInit: function  (e, itemContainer) {
      this.$document = $(itemContainer.el[0].ownerDocument)

      // get item to drag
      var closestItem = $(e.target).closest(this.options.itemSelector);
      // using the length of this item, prevents the plugin from being started if there is no handle being clicked on.
      // this may also be helpful in instantiating multidrag.
      if (closestItem.length) {
        this.item = closestItem;
        this.itemContainer = itemContainer;
        if (this.item.is(this.options.exclude) || !this.options.onMousedown(this.item, groupDefaults.onMousedown, e)) {
            return;
        }
        this.setPointer(e);
        this.toggleListeners('on');
        this.setupDelayTimer();
        this.dragInitDone = true;
      }
    },
    drag: function  (e) {
      if(!this.dragging){
        if(!this.distanceMet(e) || !this.delayMet)
          return

        this.options.onDragStart(this.item, this.itemContainer, groupDefaults.onDragStart, e)
        this.item.before(this.placeholder)
        this.dragging = true
      }

      this.setPointer(e)
      // place item under the cursor
      this.options.onDrag(this.item,
                          getRelativePosition(this.pointer, this.item.offsetParent()),
                          groupDefaults.onDrag,
                          e)

      var p = this.getPointer(e),
      box = this.sameResultBox,
      t = this.options.tolerance

      if(!box || box.top - t > p.top || box.bottom + t < p.top || box.left - t > p.left || box.right + t < p.left)
        if(!this.searchValidTarget()){
          this.placeholder.detach()
          this.lastAppendedItem = undefined
        }
    },
    drop: function  (e) {
      this.toggleListeners('off')

      this.dragInitDone = false

      if(this.dragging){
        // processing Drop, check if placeholder is detached
        if(this.placeholder.closest("html")[0]){
          this.placeholder.before(this.item).detach()
        } else {
          this.options.onCancel(this.item, this.itemContainer, groupDefaults.onCancel, e)
        }
        this.options.onDrop(this.item, this.getContainer(this.item), groupDefaults.onDrop, e)

        // cleanup
        this.clearDimensions()
        this.clearOffsetParent()
        this.lastAppendedItem = this.sameResultBox = undefined
        this.dragging = false
      }
    },
    searchValidTarget: function  (pointer, lastPointer) {
      if(!pointer){
        pointer = this.relativePointer || this.pointer
        lastPointer = this.lastRelativePointer || this.lastPointer
      }

      var distances = sortByDistanceDesc(this.getContainerDimensions(),
                                         pointer,
                                         lastPointer),
      i = distances.length

      while(i--){
        var index = distances[i][0],
        distance = distances[i][1]

        if(!distance || this.options.pullPlaceholder){
          var container = this.containers[index]
          if(!container.disabled){
            if(!this.$getOffsetParent()){
              var offsetParent = container.getItemOffsetParent()
              pointer = getRelativePosition(pointer, offsetParent)
              lastPointer = getRelativePosition(lastPointer, offsetParent)
            }
            if(container.searchValidTarget(pointer, lastPointer))
              return true
          }
        }
      }
      if(this.sameResultBox)
        this.sameResultBox = undefined
    },
    movePlaceholder: function  (container, item, method, sameResultBox) {
      var lastAppendedItem = this.lastAppendedItem
      if(!sameResultBox && lastAppendedItem && lastAppendedItem[0] === item[0])
        return;

      item[method](this.placeholder)
      this.lastAppendedItem = item
      this.sameResultBox = sameResultBox
      this.options.afterMove(this.placeholder, container, item)
    },
    getContainerDimensions: function  () {
      if(!this.containerDimensions)
        setDimensions(this.containers, this.containerDimensions = [], this.options.tolerance, !this.$getOffsetParent())
      return this.containerDimensions
    },
    getContainer: function  (element) {
      return element.closest(this.options.containerSelector).data(pluginName)
    },
    $getOffsetParent: function  () {
      if(this.offsetParent === undefined){
        var i = this.containers.length - 1,
        offsetParent = this.containers[i].getItemOffsetParent()

        if(!this.options.rootGroup){
          while(i--){
            if(offsetParent[0] != this.containers[i].getItemOffsetParent()[0]){
              // If every container has the same offset parent,
              // use position() which is relative to this parent,
              // otherwise use offset()
              // compare #setDimensions
              offsetParent = false
              break;
            }
          }
        }

        this.offsetParent = offsetParent
      }
      return this.offsetParent
    },
    setPointer: function (e) {
      var pointer = this.getPointer(e)

      if(this.$getOffsetParent()){
        var relativePointer = getRelativePosition(pointer, this.$getOffsetParent())
        this.lastRelativePointer = this.relativePointer
        this.relativePointer = relativePointer
      }

      this.lastPointer = this.pointer
      this.pointer = pointer
    },
    distanceMet: function (e) {
      var currentPointer = this.getPointer(e)
      return (Math.max(
        Math.abs(this.pointer.left - currentPointer.left),
        Math.abs(this.pointer.top - currentPointer.top)
      ) >= this.options.distance)
    },
    getPointer: function(e) {
      var o = e.originalEvent || e.originalEvent.touches && e.originalEvent.touches[0]
      return {
        left: e.pageX || o.pageX,
        top: e.pageY || o.pageY
      }
    },
    setupDelayTimer: function () {
      var that = this
      this.delayMet = !this.options.delay

      // init delay timer if needed
      if (!this.delayMet) {
        clearTimeout(this._mouseDelayTimer);
        this._mouseDelayTimer = setTimeout(function() {
          that.delayMet = true
        }, this.options.delay)
      }
    },
    scroll: function  (e) {
      this.clearDimensions()
      this.clearOffsetParent() // TODO is this needed?
    },
    toggleListeners: function (method) {
      var that = this,
      events = ['drag','drop','scroll']

      $.each(events,function  (i,event) {
        that.$document[method](eventNames[event], that[event + 'Proxy'])
      })
    },
    clearOffsetParent: function () {
      this.offsetParent = undefined
    },
    // Recursively clear container and item dimensions
    clearDimensions: function  () {
      this.traverse(function(object){
        object._clearDimensions()
      })
    },
    traverse: function(callback) {
      callback(this)
      var i = this.containers.length
      while(i--){
        this.containers[i].traverse(callback)
      }
    },
    _clearDimensions: function(){
      this.containerDimensions = undefined
    },
    _destroy: function () {
      containerGroups[this.options.group] = undefined
    }
  }

  function Container(element, options) {
    this.el = element
    this.options = $.extend( {}, containerDefaults, options)

    this.group = ContainerGroup.get(this.options)
    this.rootGroup = this.options.rootGroup || this.group
    this.handle = this.rootGroup.options.handle || this.rootGroup.options.itemSelector

    var itemPath = this.rootGroup.options.itemPath
    this.target = itemPath ? this.el.find(itemPath) : this.el

    this.target.on(eventNames.start, this.handle, $.proxy(this.dragInit, this))

    if(this.options.drop)
      this.group.containers.push(this)
  }

  Container.prototype = {
    dragInit: function  (e) {
      var rootGroup = this.rootGroup

      if( !this.disabled &&
          !rootGroup.dragInitDone &&
          this.options.drag &&
          this.isValidDrag(e)) {
        rootGroup.dragInit(e, this)
      }
    },
    isValidDrag: function(e) {
      return e.which == 1 ||
        e.type == "touchstart" && e.originalEvent.touches.length == 1
    },
    searchValidTarget: function  (pointer, lastPointer) {
      var distances = sortByDistanceDesc(this.getItemDimensions(),
                                         pointer,
                                         lastPointer),
      i = distances.length,
      rootGroup = this.rootGroup,
      validTarget = !rootGroup.options.isValidTarget ||
        rootGroup.options.isValidTarget(rootGroup.item, this)

      if(!i && validTarget){
        rootGroup.movePlaceholder(this, this.target, "append")
        return true
      } else
        while(i--){
          var index = distances[i][0],
          distance = distances[i][1]
          if(!distance && this.hasChildGroup(index)){
            var found = this.getContainerGroup(index).searchValidTarget(pointer, lastPointer)
            if(found)
              return true
          }
          else if(validTarget){
            this.movePlaceholder(index, pointer)
            return true
          }
        }
    },
    movePlaceholder: function  (index, pointer) {
      var item = $(this.items[index]),
      dim = this.itemDimensions[index],
      method = "after",
      width = item.outerWidth(),
      height = item.outerHeight(),
      offset = item.offset(),
      sameResultBox = {
        left: offset.left,
        right: offset.left + width,
        top: offset.top,
        bottom: offset.top + height
      }
      if(this.options.vertical){
        var yCenter = (dim[2] + dim[3]) / 2,
        inUpperHalf = pointer.top <= yCenter
        if(inUpperHalf){
          method = "before"
          sameResultBox.bottom -= height / 2
        } else
          sameResultBox.top += height / 2
      } else {
        var xCenter = (dim[0] + dim[1]) / 2,
        inLeftHalf = pointer.left <= xCenter
        if(inLeftHalf){
          method = "before"
          sameResultBox.right -= width / 2
        } else
          sameResultBox.left += width / 2
      }
      if(this.hasChildGroup(index))
        sameResultBox = emptyBox
      this.rootGroup.movePlaceholder(this, item, method, sameResultBox)
    },
    getItemDimensions: function  () {
      if(!this.itemDimensions){
        this.items = this.$getChildren(this.el, "item").filter(
          ":not(." + this.group.options.placeholderClass + ", ." + this.group.options.draggedClass + ")"
        ).get()
        setDimensions(this.items, this.itemDimensions = [], this.options.tolerance)
      }
      return this.itemDimensions
    },
    getItemOffsetParent: function  () {
      var offsetParent,
      el = this.el
      // Since el might be empty we have to check el itself and
      // can not do something like el.children().first().offsetParent()
      if(el.css("position") === "relative" || el.css("position") === "absolute"  || el.css("position") === "fixed")
        offsetParent = el
      else
        offsetParent = el.offsetParent()
      return offsetParent
    },
    hasChildGroup: function (index) {
      return this.options.nested && this.getContainerGroup(index)
    },
    getContainerGroup: function  (index) {
      var childGroup = $.data(this.items[index], subContainerKey)
      if( childGroup === undefined){
        var childContainers = this.$getChildren(this.items[index], "container")
        childGroup = false

        if(childContainers[0]){
          var options = $.extend({}, this.options, {
            rootGroup: this.rootGroup,
            group: groupCounter ++
          })
          childGroup = childContainers[pluginName](options).data(pluginName).group
        }
        $.data(this.items[index], subContainerKey, childGroup)
      }
      return childGroup
    },
    $getChildren: function (parent, type) {
      var options = this.rootGroup.options,
      path = options[type + "Path"],
      selector = options[type + "Selector"]

      parent = $(parent)
      if(path)
        parent = parent.find(path)

      return parent.children(selector)
    },
    _serialize: function (parent, isContainer) {
      var that = this,
      childType = isContainer ? "item" : "container",

      children = this.$getChildren(parent, childType).not(this.options.exclude).map(function () {
        return that._serialize($(this), !isContainer)
      }).get()

      return this.rootGroup.options.serialize(parent, children, isContainer)
    },
    traverse: function(callback) {
      $.each(this.items || [], function(item){
        var group = $.data(this, subContainerKey)
        if(group)
          group.traverse(callback)
      });

      callback(this)
    },
    _clearDimensions: function  () {
      this.itemDimensions = undefined
    },
    _destroy: function() {
      var that = this;

      this.target.off(eventNames.start, this.handle);
      this.el.removeData(pluginName)

      if(this.options.drop)
        this.group.containers = $.grep(this.group.containers, function(val){
          return val != that
        })

      $.each(this.items || [], function(){
        $.removeData(this, subContainerKey)
      })
    }
  }

  var API = {
    enable: function() {
      this.traverse(function(object){
        object.disabled = false
      })
    },
    disable: function (){
      this.traverse(function(object){
        object.disabled = true
      })
    },
    serialize: function () {
      return this._serialize(this.el, true)
    },
    refresh: function() {
      this.traverse(function(object){
        object._clearDimensions()
      })
    },
    destroy: function () {
      this.traverse(function(object){
        object._destroy();
      })
    }
  }

  $.extend(Container.prototype, API)

  /**
   * jQuery API
   *
   * Parameters are
   *   either options on init
   *   or a method name followed by arguments to pass to the method
   */
  $.fn[pluginName] = function(methodOrOptions) {
    var args = Array.prototype.slice.call(arguments, 1)

    return this.map(function(){
      var $t = $(this),
      object = $t.data(pluginName)

      if(object && API[methodOrOptions])
        return API[methodOrOptions].apply(object, args) || this
      else if(!object && (methodOrOptions === undefined ||
                          typeof methodOrOptions === "object"))
        $t.data(pluginName, new Container($t, methodOrOptions))

      return this
    });
  };

}(jQuery, window, 'sortable');
// taggingJS v1.3.3
//    2014-10-24

// Copyright (c) 2014 Fabrizio Fallico

// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
//  all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.
(function( $, window, document, undefined ) {

    /**
     * taggingJS Constructor
     *
     * @param obj elem     DOM object of tag box
     * @param obj options  Custom JS options
     */
    var Tagging = function( elem, options ) {
        this.elem    = elem;          // The tag box
        this.$elem   = $( elem );     // jQuerify tag box
        this.options = options;       // JS custom options
        this.tags = [];               // Here we store all tags
        // this.$type_zone = void 0;  // The tag box's input zone
    };

    /**
     * taggingJS Prototype
     */
    Tagging.prototype = {


        // All special Keys
        keys: {
            // Special keys to add a tag
            add: {
                comma:    188,
                enter:    13,
                spacebar: 32,
            },

            // Special keys to remove last tag
            remove: {
                del: 46,
                backspace: 8,
            }
        },

        // Default options value
        defaults: {
            "case-sensitive": false,                        // True to allow differences between lowercase and uppercase
            "close-char": "&times;",                        // Single Tag close char
            "close-class": "tag-i",                         // Single Tag close class
            "edit-on-delete": true,                         // True to edit tag that has just been removed from tag box
            "forbidden-chars": [ ".", "_", "?" ],           // Array of forbidden characters
            "forbidden-chars-callback": window.alert,       // Function to call when there is a forbidden chars
            "forbidden-chars-text": "Forbidden character:", // Basic text passed to forbidden-chars callback
            "forbidden-words": [],                          // Array of forbidden words
            "forbidden-words-callback": window.alert,       // Function to call when there is a forbidden words
            "forbidden-words-text": "Forbidden word:",      // Basic text passed to forbidden-words callback
            "no-backspace": false,                          // Backspace key remove last tag, true to avoid that
            "no-comma": false,                              // Comma "," key add a new tag, true to avoid that
            "no-del": false,                                // Delete key remove last tag, true to avoid that
            "no-duplicate": true,                           // No duplicate in tag box
            "no-duplicate-callback": window.alert,          // Function to call when there is a duplicate tag
            "no-duplicate-text": "Duplicate tag:",          // Basic text passed to no-duplicate callback
            "no-enter": false,                              // Enter key add a new tag, true to avoid that
            "no-spacebar": false,                           // Spacebar key add a new tag by default, true to avoid that
            "pre-tags-separator": ", ",                     // By default, you must put new tags using a new line
            "tag-box-class": "tagging",                     // Class of the tag box
            "tag-char": "#",                                // Single Tag char
            "tag-class": "tag",                             // Single Tag class
            "tags-input-name": "tag",                       // Name to use as name="" in single tags (by default tag[])
            "tag-on-blur": true,                            // Add the current tag if user clicks away from type-zone
            "type-zone-class": "type-zone",                 // Class of the type-zone
        },

        /**
         * Add a tag
         *
         * @param string            text  Text to add as tag, if null we get the content of tag box type_zone.
         * @return boolean|funtion        true if OK; false if NO; function with some config error.
         */
        add: function( text ) {

            // console.log( 'add' );

            var $tag, l, self,
                index, forbidden_words,
                callback_f, callback_t;

            // Caching this
            self = this;

            // If text is an array, call add on each element
            if ( $.isArray( text ) ) {
                // Adding text present on type_zone as tag on first call
                return $.each( text, function() {
                    self.add( this + "" );
                });
            }

            // Forbidden Words shortcut
            forbidden_words = self.config[ "forbidden-words" ];

            // If no text is passed, take it as text of $type_zone and then empty it
            if ( ! text ) {
                text = self.valInput();
                self.emptyInput();
            }

            // If text is empty too, then go out
            if ( ! text || ! text.length ) {
                return false;
            }

            // If case-sensitive is true, write everything in lowercase
            if ( ! self.config[ "case-sensitive" ] ) {
                text = text.toLowerCase();
            }

            // Checking if text is a Forbidden Word
            l = forbidden_words.length;
            while ( l-- ) {

                // Looking for a forbidden words
                index = text.indexOf( forbidden_words[ l ] );

                // There is a forbidden word
                if ( index >= 0 ) {

                    // Removing all text and ','
                    self.emptyInput();

                    // Renaiming
                    callback_f = self.config[ "forbidden-words-callback" ];
                    callback_t = self.config[ "forbidden-words-text" ];

                    // Remove as a duplicate
                    return self.throwError( callback_f, callback_t, text );
                }
            }

            // If no-duplicate is true, check that the text is not already present
            if ( self.config[ "no-duplicate" ] ) {

                // Looking for each text inside tags
                l = self.tags.length;
                while ( l-- ) {
                    if ( self.tags[ l ].pure_text === text ) {

                        // Removing all text and ','
                        self.emptyInput();

                        // Renaiming
                        callback_f = self.config[ "no-duplicate-callback" ];
                        callback_t = self.config[ "no-duplicate-text" ];

                        // Remove the duplicate
                        return self.throwError( callback_f, callback_t, text );

                    }
                }
            }

            // Creating a new div for the new tag
            $tag = $( document.createElement( "div" ) )
                        .addClass( self.config[ "tag-class" ] )
                        .html(  "<span>" + self.config[ "tag-char" ] + "</span> " + text  );

            // Creating and Appending hidden input
            $( document.createElement( "input" ) )
                .attr( "type", "hidden" )
                // custom input name
                .attr( "name", self.config[ "tags-input-name" ] + "[]" )
                .val( text )
                .appendTo( $tag );

            // Creating and tag button (with "x" to remove tag)
            $( document.createElement( "a" ) )
                .attr( "role", "button" )
                // adding custom class
                .addClass( self.config[ "close-class" ] )
                // using custom char
                .html( self.config[ "close-char" ] )
                // click addEventListener
                .click(function() {
                    self.remove( $tag );
                })
                // finally append close button to tag element
                .appendTo( $tag );

            // Adding pure_text and position property to $tag
            $tag.pure_text = text;

            // Adding to tags the new tag (as jQuery Object)
            self.tags.push( $tag );

            // Adding tag in the type zone
            self.$type_zone.before( $tag );

            return true;
        },

        /**
         * Add a special keys
         *
         * @param  array       arr  Array like ['type', obj], where 'type' is 'add' or 'remove', obj is { key_name: key_num }
         * @return string|obj       Error message or actually 'type'_key (add_key or remove_key).
         */
        addSpecialKeys: function( arr ) {
            // console.log( 'addSpecialKeys' );

            var self, value, to_add, obj, type;

            self   = this;
            type   = arr[0];
            obj    = arr[1];
            to_add = {};

            // If obj is an array, call addSpecialKeys on each element
            if ( $.isArray( obj ) ) {
                return $.each( obj, function() {
                    self.addSpecialKeys( [ type, this ] );
                });
            }

            // Check if obj is really an object
            // @link http://stackoverflow.com/a/16608045
            if ( ( ! obj ) && ( obj.constructor !== Object ) ) {
                return "Error -> The second argument is not an Object!";
            }

            for ( value in obj ) {
                if ( obj.hasOwnProperty( value ) ) {
                    // @link stackoverflow.com/a/3885844
                    if ( obj[ value ] === +obj[ value ] && obj[ value ] === ( obj[ value ]|0 ) ) {
                        $.extend( to_add, obj );
                    }
                }
            }

            self.keys[ type ] = $.extend( {}, to_add, self.keys[ type ] );

            return self.keys[ type ];
        },

        /**
         * Opposite of init, remove type_zone, all tags and other things.
         *
         * @return boolean
         */
        destroy: function() {
            // console.log( 'destroy' );

            // Removing the type-zone
            this.$elem.find( "." + this.config[ "type-zone-class" ] ).remove();

            // Removing all tags
            this.$elem.find( "." + this.config[ "tag-class" ] ).remove();

            // Destroy tag-box parameters
            this.$elem.data( "tag-box", null );

            // Exit with success
            return true;
        },

        /**
         * Empty tag box's type_zone
         *
         * @return $_obj       The type_zone itself
         */
        emptyInput: function() {
            // console.log( 'emptyInput' );

            this.focusInput();

            return this.valInput( "" );
        },

        /**
         * Trigger focus on tag box's input
         *
         * @return $_obj The tag box's input
         */
        focusInput: function() {
            // console.log( 'focusInput' );

            return this.$type_zone.focus();
        },

        /**
         * Get Data attributes custom options
         *
         * @return object  Tag-box data attributes options
         */
        getDataOptions: function() {

            var key, data_option, data_options;

            // Here we store all data_options
            data_options = {};

            // For each option
            for ( key in this.defaults ) {

                // Getting value
                data_option = this.$elem.data( key );

                // Checking if it is not undefined
                if ( data_option /*!= null*/ ) {

                    // Saving in data_options object
                    data_options[ key ] = data_option;

                }
            }

            return data_options;
        },

        /**
         * Return all special keys inside an object (without distinction)
         *
         * @return obj
         */
        getSpecialKeys: function() {
            return $.extend( {}, this.keys.add, this.keys.remove );
        },

        /**
         * Return all special keys inside an object (with distinction)
         *
         * @return obj
         */
        getSpecialKeysD: function() {
            return this.keys;
        },

        /**
         * Return all tags as string
         *
         * @return array   All tags as member of strings.
         */
        getTags: function() {
            // console.log( 'getTags' );

            var all_txt_tags, i, l;

            l = this.tags.length;
            all_txt_tags = [];

            for ( i = 0; i < l; i += 1 ) {
                all_txt_tags.push( this.tags[ i ].pure_text );
            }

            return all_txt_tags;
        },

        /**
         * Return all tags as object
         *
         * @return array   All tags as member of objects.
         */
        getTagsObj: function() {
            // console.log( 'getTagsObj' );

            return this.tags;
        },

        /**
         * Init method to bootstrap all things
         *
         * @return $_obj   The jQuerify tag box
         */
        init: function() {
            // console.log( 'init' );

            var init_text, self, text;

            self = this;

            // Getting all data Parameters to fully customize the single tag box selecteds
            self.config = $.extend( {}, self.defaults, self.options, self.getDataOptions() );

            // Pre-existent text
            init_text = self.$elem.text();

            // Empty the original div
            self.$elem.empty();

            // Create the type_zone input using custom class and contenteditable attribute
            self.$type_zone = $( document.createElement( "input" ) )
                             .addClass( self.config[ "type-zone-class" ] )
                             .attr( "contenteditable", true );

            // Adding tagging class and appending the type zone
            self.$elem
                .addClass( self.config[ "tag-box-class" ] )
                .append( self.$type_zone );

            // Keydown event listener on tag box type_zone
            self.$type_zone.keydown(function( e ) {
                var key, index, l, pressed_key, all_keys,
                    forbidden_chars, actual_text,
                    callback_f, callback_t;

                all_keys = self.getSpecialKeys();

                // Forbidden Chars shortcut
                forbidden_chars = self.config[ "forbidden-chars" ];

                // Actual text in the type_zone
                actual_text     = self.valInput();

                // The pressed key
                pressed_key     = e.which;

                // console.log( pressed_key );

                // For in loop to look to Remove Keys
                if ( ! actual_text ) {

                    for ( key in all_keys ) {

                        // Some special key
                        if ( pressed_key === all_keys[ key ] ) {

                            // Enter or comma or spacebar - We cannot add an empty tag
                            if ( self.keys.add[ key ] /*!= null*/ ) {

                                // Prevent Default
                                e.preventDefault();

                                // Exit with 'true'
                                return true;
                            }

                            // Backspace or Del
                            if ( self.keys.remove[ key ] /*!= null*/ ) {

                                // Checking if it enabled
                                if ( ! self.config[ "no-" + key ] ) {

                                    // Prevent Default
                                    e.preventDefault();

                                    return self.remove();

                                }
                            }
                        }
                    }
                } else {

                    // For loop to remove Forbidden Chars from Text
                    l = forbidden_chars.length;
                    while ( l-- ) {

                        // Looking for a forbidden char
                        index = actual_text.indexOf( forbidden_chars[ l ] );

                        // There is a forbidden text
                        if ( index >= 0 ) {

                            // Prevent Default
                            e.preventDefault();

                            // Removing Forbidden Char
                            actual_text = actual_text.replace( forbidden_chars[ l ], "" );

                            // Update type_zone text
                            self.focusInput();
                            self.valInput( actual_text );

                            // Renaiming
                            callback_f = self.config[ "forbidden-chars-callback" ];
                            callback_t = self.config[ "forbidden-chars-text" ];

                            // Remove the duplicate
                            return self.throwError( callback_f, callback_t, forbidden_chars[ l ] );
                        }
                    }

                    // For in to look in Add Keys
                    for ( key in self.keys.add ) {

                        // Enter or comma or spacebar if enabled
                        if ( pressed_key === self.keys.add[ key ] ) {

                            if ( ! self.config[ "no-" + key ] ) {

                                // Prevent Default
                                e.preventDefault();

                                // Adding tag with no text
                                return self.add();
                            }
                        }
                    }
                }

                // Exit with success
                return true;
            });

            // Add tag on a click away from the type_zone
            if ( self.config[ "tag-on-blur" ] ) {
                self.$type_zone.focusout(function() {

                    // Get text from current input box
                    text = self.valInput();

                    // If text is empty, then continue focusout
                    if ( ! text || ! text.length ) {
                        return false;
                    }

                    // Otherwise add the tag first
                    return self.add();
                });
            }

            // On click, we focus the type_zone
            self.$elem.on( "click", function() {
                self.focusInput();
            });

            // Refresh tag box using refresh public method with a text
            self.refresh( init_text );

            // We don't break the chain, right?
            return self;
        },

        /**
         * Remove and insert all tag
         *
         * @param  string  text String with all tags (if null, simply we call getTags method)
         * @return boolean
         */
        refresh: function( text ) {
            // console.log( 'refresh' );

            var self, separator;

            self = this;
            separator = self.config[ "pre-tags-separator" ];

            text = text || self.getTags().join( separator );

            self.reset();

            // Adding text present on type_zone as tag on first call
            $.each( text.split( separator ), function() {
                self.add( this + "" );
            });

            return true;
        },

        /**
         * Remove last tag in tag box's type_zone or a specified one.
         *
         * @param  string|$_obj         The text of tag to remove or the $_obj of itself.
         * @return string|$_obj         An error if the tag is not found, or the $_obj of removed tag.
         */
        remove: function( $tag ) {
            // console.log( 'remove' );

            var self, text, l;

            self = this;

            // If $tag is an array, call remove on each element
            if ( $.isArray( $tag ) ) {
                // Adding text present on type_zone as tag on first call
                return $.each( $tag, function() {
                    self.remove( this + "" );
                });
            }

            // If $tag is a string, we must find the $_obj of the tag
            if ( typeof $tag === "string" ) {

                // Renaiming
                text = $tag;

                // Retrieving the $_obj of the tag
                $tag = self.$elem.find( "input[value=" + text + "]" ).parent();

                // If nothing is found, return an error
                if ( ! $tag.length ) {
                    return "Error -> Tag not found";
                }
            }

            // Not specified any tags
            if ( ! $tag ) {

                // Retrieving the last
                $tag = self.tags.pop();

            } else {

                // Iterate the tags array and removing the specified tags
                l = self.tags.length;
                while ( l-- ) {
                    // Confront the content of $tag and the tags array
                    if ( self.tags[ l ][0].innerHTML === $tag[0].innerHTML ) {
                        // Removing definitively
                        self.tags.splice( l, 1 );
                    }
                }
            }

            // Getting text if not alredy setted
            text = text || $tag.pure_text;

            // Removing last tag
            $tag.remove();

            // If you want to change the text when a tag is deleted
            if ( self.config[ "edit-on-delete" ] ) {

                // Empting input
                self.emptyInput();

                // Set the new text
                self.valInput( $tag.pure_text );
            }

            return $tag;

        },

        /**
         * Alias of reset
         *
         * @return array  All removed tags
         */
        removeAll: function() {
            // console.log( 'removeAll' );

            return this.reset();
        },

        /**
         * Remove a special keys
         *
         * @param  array  arr  Array like ['type', key_code], where 'type' is 'add' or 'remove', key_code is the key number
         * @return obj         Actually 'type'_key (add_key or remove_key).
         */
        removeSpecialKeys: function( arr ) {
            // console.log( 'removeSpecialKeys' );

            var self, value, to_add, key_code, type;

            self     = this;
            type     = arr[0];
            key_code = arr[1];
            to_add   = {};

            // If key_code is an array, call removeSpecialKeys on each element
            if ( $.isArray( key_code ) ) {
                return $.each( key_code, function() {
                    self.removeSpecialKeys( [ type, this ] );
                });
            }

            // Iterate proper array
            for ( value in self.keys[ type ] ) {
                if ( self.keys[ type ].hasOwnProperty( value ) ) {

                    // If the key_code is equal to the actual key_code
                    if ( self.keys[ type ][ value ] === key_code ) {
                        // We set to undefined the property
                        self.keys[ type ][ value ] = undefined;
                    }
                }
            }

            return self.keys[ type ];
        },

        /**
         * Remove all tags from tag box's type_zone
         *
         * @return array  All removed tags
         */
        reset: function() {
            // console.log( 'reset' );

            while (this.tags.length ) {
                this.remove( this.tags[ this.tags.length ] );
            }

            this.emptyInput();

            return this.tags;

        },

        /**
         * Raise a callback with some text
         *
         * @param  function callback_f Callback function
         * @param  string   callback_t Basic text
         * @param  string   tag_text   Tag text
         * @return function
         */
        throwError: function( callback_f, callback_t, tag_text ) {
            // Calling the callback with t as th
            return callback_f( [ callback_t + " '" + tag_text + "'." ] );
        },

        /**
         * Get or Set the tag box type_zone's value
         *
         * @param  string        text String to put as tag box type_zone's value
         * @return string|$_obj       The value of tag box's type_zone or the type_zone itself
         */
        valInput: function( text ) {
            // console.log( 'valInput' );

            if ( text == null ) {
                return this.$type_zone.val();
            }

            return this.$type_zone.val( text );

        },

    };

    /**
     * Registering taggingJS
     *
     * @param  obj|string arg1 Object with custom options or string with a method
     * @param  string     arg2 Argument to pass to the method
     * @return $_Obj           All tag-box or result from "arg2" public method.
     */
    $.fn.tagging = function( arg1, arg2 ) {
        var results = [];

        this.each(function() {
            var $this, tagging, val;

            $this   = $( this );
            tagging = $this.data( "tag-box" );

            // Initialize a new tags input
            if ( ! tagging ) {

                tagging = new Tagging( this, arg1 );

                $this.data( "tag-box", tagging );

                tagging.init();

                results.push( tagging.$elem );

            } else {

                // Invoke function on existing tags input
                val = tagging[ arg1 ]( arg2 );

                if ( val /*!= null*/ ) {
                    results.push( val );
                }
            }
        });

        if ( typeof arg1 === "string") {
            // Return the results from the invoked function calls
            return ( results.length > 1 ) ? results : results[0];
        }

        return results;
    };

})( window.jQuery, window, document );

// jQuery on Ready example
// (function( $, window, document, undefined ) {
//     $( document ).ready(function() {
//         var t = $( ".tagging-js" ).tagging();
//         t[0].addClass( "form-control" );
//         // console.log( t[0] );
//     });
// })( window.jQuery, window, document );

//# sourceMappingURL=jquery.plugins.js.map
