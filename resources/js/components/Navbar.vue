<template>
  <div class="navbar">
    <menu class="navbar__nav-menu">
      <Link class="navbar__link" href="/clients">Clients</Link>
      <Link class="navbar__link" href="/developers">Developers</Link>
      <Link class="navbar__link" href="/projects">Projects</Link>
      <Link class="navbar__link" href="/work-logs">Work Logs</Link>
    </menu>
    <menu class="navbar__user-menu">
      <div class="navbar__user-info">
        <img src="" alt="Avatar" class="navbar__user-img" />
        <p class="navbar__username">{{ $page.props?.user?.login }}</p>
      </div>
      <div class="navbar__user-btns">
        <PrimaryButton class="navbar__user-btn">Change password</PrimaryButton>
        <Link
          href="/logout"
          class="navbar__user-logout"
          method="post"
          as="button"
        >
          <PrimaryButton class="navbar__user-btn">Logout</PrimaryButton>
        </Link>
      </div>
    </menu>
  </div>
</template>

<script setup>
import PrimaryButton from "./UI/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
</script>

<style lang="scss" scoped>
@import "../../scss/var";
.navbar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 1000;

  background-color: $mainTextColor;
  display: flex;

  &__username {
    color: white;
    font-weight: 500;
    font-size: 20px;
  }

  &__nav-menu,
  &__user-menu {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: center;
    padding: 20px;
  }

  &__user-logout {
    width: 100%;
  }

  &__user-btns {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  &__user-btn {
    border: 2px solid white;
    color: white;
    width: 100%;
    font-size: 18px;
    padding: 8px;

    &:hover {
      border: 2px solid $mainBorder;
      color: $mainTextColor;
      background-color: white;
    }
  }

  &__nav-menu {
    border-right: 2px solid $mainBorder;
  }

  &__link {
    font-size: 23px;
    color: $mainBorder;
    transition: all 0.3s ease;
    font-weight: 500;

    &:hover {
      color: white;
    }
  }
}
</style>
