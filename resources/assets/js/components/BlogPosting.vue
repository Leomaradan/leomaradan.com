<template>
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <section v-if="image && !single" class="image">
            <time v-if="date" itemprop="dateCreated" datetime="{{ date.ISO }}" v-html="dateFormater"></time>
            <div class="cover" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <img v-bind:src="image" itemprop="contentUrl" alt="{{ imageCaption }}">
            </div>
        </section>   
        <section v-bind:class="{ Card: image && !single }" class="Post">
                    <time v-if="date && !image && single" itemprop="dateCreated" datetime="{{ date.ISO }}" v-html="dateFormater"></time>

                <h1 itemprop="name">{{ title }}</h1>
                <div class="PostInfo">
                    <span v-if="author" itemprop="author">{{ author }}</span>
                    <span v-if="category" class="category">Catégorie : <a href="{{ category.link }}" rel="tag">{{ category.name }}</a></span>
                    <span v-if="tags" class="TagsCloud">
                        <a v-for="tag in tags" href="{{ tag.link }}">{{ tag.name }}</a>
                    </span>

                </div>
                <div v-if="image && single" class="image">
                    <img v-bind:src="image" itemprop="contentUrl" alt="{{ imageCaption }}">
                </div>
                <div itemprop="text">
                    <slot></slot>
                </div>
                <a v-if="url" href="{{ url }}" class="HighlightLink" itemprop="url" rel="bookmark">{{ urlCaption }}</a>

                <template v-if="moreHtml">{{ moreHtml }}</template>               
        </section>         
    </article>
</template>

<script>

	export default {

		name: 'BlogPosting',

		props: {
                    image: String,
                    imageCaption: {
                        type: String,
                        default: ""
                    },
                    date: Object,
                    title: {
                        type: String,
                        required: true
                    },
                    author: String,
                    tags: Array,
                    category: Object,
                    url: String,
                    urlCaption: {
                        type: String,
                        default: "Lire la suite"
                    },
                    moreHtml: String,
                    single: {
                        type: Boolean,
                        default: false
                    }
		},

		data () {
			return {}
		},
                computed: {
                    dateFormater: function() {
                        let dates = this.date.localized.split('-'),
                            day = dates[0],
                            month = dates[1],
                            year = dates[2];
                        
                        if(month.length > 5) {
                            month = month.substring(0,3) + '.';
                        }
                        return '<span>'+day+'</span><span>'+month+'</span><span>'+year+'</span>';
                    }
                }
	}
</script>