<template>
  <transition name="nav-expand">
    <nav class="bui-navigation"
         v-if="open"
         v-on-clickaway="close"
         :class="{ 'night': night }">
      <icon-button class="bui-navigation-close"
                   v-if="showCloseButton"
                   icon="close"
                   type="clear"
                   @click.native="close"></icon-button>
      <slot></slot>
    </nav>
  </transition>
</template>

<script>
  import { parentHasClass } from 'app/components/utils/functions'
  import IconButton from './IconButton'
  import { mixin as ClickAway } from 'vue-clickaway'

  export default {
    mixins: [ClickAway],
    name: 'bui-navigation',
    props: {
      open: Boolean,
      activeClickAway: {
        type: Boolean,
        default: true
      },
      showCloseButton: {
        type: Boolean,
        default: true
      },
      night: Boolean
    },
    methods: {
      close (event) {
        if (!this.activeClickAway) { return }
        this.$nextTick(() => {
          if (!parentHasClass(event.target, 'unclose-navigation')) {
            this.$emit('close')
          }
        })
      }
    },
    components: {
      IconButton
    }
  }
</script>

<style lang="scss">
  @import '~style/variables.scss';

  .bui-navigation {
    position: fixed;
    z-index: 2;
    width: 250px;
    background-color: $white;
    top: 0;
    bottom: 0;
    left: 0;
    @include card(3);

    &.night {
      background-color: $palette-grey-600;
    }

    &.nav-expand-enter-active, &.nav-expand-leave-active {
      transition: left .25s ease;
      left: 0;
    }
    &.nav-expand-enter, &.nav-expand-leave-active {
      left: -250px;
    }

    .bui-navigation-close {
      position: absolute;
      right: 0;
      margin: 10px 10px 0 0;
    }

    p {
      margin-top: 10px;
      padding: 5px;
    }
  }
</style>