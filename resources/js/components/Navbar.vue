<template>
  <PrimaryButton
    class="navbar__user-btn navbar__btn"
    :class="{ 'navbar__btn-close': !isOpen }"
    @click="isOpen = !isOpen"
    ><div class="navbar__btn-lines">
      <div
        class="navbar__btn-line"
        :class="{ 'navbar__btn-first-line': isOpen }"
      ></div>
      <div
        class="navbar__btn-line"
        :class="{ 'navbar__btn-second-line': isOpen }"
      ></div>
      <div
        class="navbar__btn-line"
        :class="{ 'navbar__btn-third-line': isOpen }"
      ></div>
    </div>
  </PrimaryButton>
  <div class="navbar" :class="{ 'navbar--active': isOpen }">
    <menu class="navbar__nav-menu">
      <Link class="navbar__link" href="/">Dashboard</Link>
      <Link class="navbar__link" href="/clients">Clients</Link>
      <Link class="navbar__link" href="/projects">Projects</Link>
      <Link class="navbar__link" href="/volunteers">Volunteers</Link>
      <Link class="navbar__link" href="/work-logs">Work Logs</Link>
    </menu>
    <menu class="navbar__user-menu">
      <div class="navbar__user-info">
        <p class="navbar__username">{{ $page.props?.user?.login }}</p>
      </div>
      <div class="navbar__user-btns">
        <PrimaryButton
          class="navbar__user-btn"
          @click="isChangingPassword = true"
          v-if="!isChangingPassword"
          >Change password</PrimaryButton
        >
        <ChangePasswordForm
          v-if="isChangingPassword"
          @cancel="isChangingPassword = false"
        />
        <Link
          href="/logout"
          class="navbar__user-logout"
          method="post"
          as="button"
          @click="isLoggingOut = true"
        >
          <PrimaryButton
            class="navbar__user-btn"
            :class="isLoggingOut ? 'navbar__user-btn__disabled' : null"
            :btnProps="{ disabled: isLoggingOut }"
            >Logout</PrimaryButton
          >
        </Link>
      </div>
    </menu>
  </div>
</template>

<script setup>
import PrimaryButton from "./UI/PrimaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import ChangePasswordForm from "./ChangePasswordForm.vue";

const isLoggingOut = ref(false);
const isChangingPassword = ref(false);
const isOpen = ref(false);
</script>

<style lang="scss" scoped>
@import "../../scss/var";

.open-navbar {
  position: fixed;
  top: 0;
  left: 0;
  border-color: $mainBorder;
  border-radius: 0;

  &__line {
    width: 15px;
  }

  &:hover {
    background-color: transparent;
  }
}
.navbar {
  position: fixed;
  top: 0;
  bottom: 0;
  right: 0;
  z-index: 1000;

  background-color: $mainTextColor;
  display: flex;
  transform: translateX(100%);
  transition: 0.3s all ease;

  &--active {
    transform: translateX(0);
  }

  &__user-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  &__user-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
  }

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
    padding: 60px 20px 20px 20px;
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
    font-size: 16px;
    padding: 5px 8px;
    font-weight: 700;

    &:hover {
      border: 2px solid $mainBorder;
      color: $mainTextColor;
      background-color: white;
    }

    &__disabled {
      &:hover {
        border: 2px solid white;
        color: white;
        background-color: transparent;
      }
    }
  }

  &__nav-menu {
    border-right: 2px solid $mainBorder;
  }

  &__link {
    font-size: 23px;
    color: white;
    transition: all 0.3s ease;
    font-weight: 500;

    &:hover {
      color: $mainBorder;
    }
  }

  &__btn {
    position: absolute;
    top: 5px;
    right: 25px;
    width: 30px;
    height: 30px;
    z-index: 8000;
    border-radius: 0;
    border-color: $mainBorder;
    background-color: white;
    color: $mainTextColor;
    transition: 0.3s all ease;
    padding: 0;

    &:hover {
      background-color: $mainBorder;
      color: white;

      .navbar__btn-line {
        background-color: rgb(214, 0, 0);
      }
    }

    &-lines {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    &-line {
      width: 100%;
      height: 5px;
      background-color: $mainTextColor;
      transition: 0.3s all ease;
    }

    &-close {
      border: none;

      &:hover {
        background-color: transparent;
        border: none;
      }
    }

    &-first-line {
      transform: rotate(45deg);
      position: relative;
      top: 9px;
    }

    &-second-line {
      opacity: 0;
    }

    &-third-line {
      transform: rotate(-45deg);
      position: relative;
      top: -9px;
    }
  }
}
</style>
