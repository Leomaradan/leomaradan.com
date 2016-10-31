<template>
    <div class="Box" v-bind:class="{ Link: isLink, Photo: image, Long: Long, Post: isPost, Landscape: isLandscape, fancybox: isFancybox }">
        <template v-if="isPost">
            <img v-if="image" v-bind:src="image" v-on:load="setLandscape" alt="{{imageAlt}}">
            <div class="Box-Content">
                <slot></slot>
                <a v-if="link" href="{{link}}" target={{linkTarget}}>{{linkLabel}}</a>
            </div>
            
        </template>
        <template v-else>
            <template v-if="isLink">
                <div><slot></slot></div>
                <a v-if="link" href="{{link}}" target={{linkTarget}}>{{linkLabel}}</a>
            </template>
            <template v-else>
                <a v-if="link" href="{{link}}" target={{linkTarget}}>
                    <slot></slot>
                    <img v-if="image" v-bind:src="image" v-on:load="setLandscape" alt="{{imageAlt}}">
                    <template v-else>{{linkLabel}}</template>
                    </a>
                <a v-else><slot></slot><img v-if="image" v-bind:src="image" v-on:load="setLandscape" alt="{{imageAlt}}"></a>
            </template>
        </template>
    </div>
</template>

<script>

	export default {

		name: 'MasonryBox',

		props: {
                    image: String,
                    imageAlt: {
                        type: String,
                        default: ''
                    },
                    link: String,
                    linkLabel: {
                        type: String,
                        default: 'Lire la suite'
                    },
                    linkTarget: {
                        type: String,
                        default: '_self'
                    },
                    isPost: String,
                    isLink: String,
                    isLandscape: {
                        type: Boolean,
                        default: false
                    },
                    isFancybox: {
                        type: Boolean,
                        default: false
                    }
		},

		data () {
			return {}
		},
                computed: {
                    Long: function() {
                        if(this._slotContents !== undefined) {
                            return this._slotContents.default.textContent.length > 300;
                        }
                        return false;
                    }
                },
                methods: {
                    setLandscape: function() {
                        let w = $("img[src='"+this.image+"']")[0].naturalWidth;
                        let h = $("img[src='"+this.image+"']")[0].naturalHeight;
                        if(w > h) {
                            this.isLandscape = true;
                        }
                    }
                }
	}
</script>