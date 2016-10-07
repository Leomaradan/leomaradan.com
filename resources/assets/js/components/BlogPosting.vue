<template>
    <article itemscope itemtype="http://schema.org/BlogPosting">
        <section v-if="image" class="image">
            <time v-if="date" itemprop="dateCreated" datetime="{{ Date.toISOString() }}">{{ date }}</time>
            <div class="cover" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                    <img src="{{ image }}" itemprop="contentUrl" alt="{{ imageCaption }}">
            </div>
        </section>   
        <section v-bind:class="{ Card: image }" class="Post">
                    <time v-if="date && !image" itemprop="dateCreated" datetime="{{ Date.toISOString() }}">{{ date }}</time>

                <h1 itemprop="name">{{ title }}</h1>
                <span v-if="author" itemprop="author">{{ author }}</span>

                <span v-if="tags" class="TagsCloud">
                    <a v-for="tag in tags" href="#">{{ tag.name }}</a>
                </span>
                <span v-if="category" class="category"><a href="#" rel="tag">{{ category }}</a></span>

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
                    date: String,
                    title: {
                        type: String,
                        required: true
                    },
                    author: String,
                    tags: Array,
                    category: String,
                    url: String,
                    urlCaption: {
                        type: String,
                        default: "Lire la suite"
                    },
                    moreHtml: String
		},

		data () {
			return {}
		},
                computed: {
                    Date: function() {
                        return new Date(this.date);
                    }
                }
	}
</script>