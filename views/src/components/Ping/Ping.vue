<template>
	<div class="pt-10">
		<template v-if="pingsLoaded">
			<ul>
				<li v-for="ping in pings">
					{{ping}}
				</li>
			</ul>
		</template>
		<Loader v-else/>
	</div>
</template>

<script>
	import Loader from '../partials/Loader.vue';
	import {mapGetters} from 'vuex';

	export default {
		computed: {
			...mapGetters({
				pings: 'allPings',
				pingsLoaded: 'allPingsLoaded',
			}),

			pageContent() {
				return this.page(this.$route.params.pageSlug);
			},
		},

		components: {
			Loader,
		},
		mounted() {
			this.$store.dispatch('getPongs',{count: 5});
		}
	};
</script>

<style type="postcss" scoped>
	.page-content {
		& >>> p {
			margin-bottom: 1rem;
		}
	}
</style>
