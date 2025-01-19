<template>
  <nav
    class="navbar navbar-expand-lg !tw-rounded-none !tw-fixed tw-w-full !tw-h-20 !tw-bg-primary !tw-py-0"
  >
    <div class="container-fluid tw-flex tw-items-center tw-justify-center">
      <img
        @click="router.push('/')"
        src="../public/images/logo.svg"
        class="navbar-brand tw-w-32 tw-m-5 hover:tw-cursor-pointer"
      />
      <Button
        outlined
        severity="secondary"
        class="navbar-toggler !tw-text-white hover:!tw-text-black tw-m-5"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar"
      >
        <i class="pi pi-bars"></i>
      </Button>
      <div
        class="offcanvas offcanvas-start !tw-border-0 !tw-rounded-r-xl !tw-w-64 !tw-bg-primary"
        tabindex="-1"
        id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel"
      >
        <div class="offcanvas-header !tw-items-center">
          <img src="../public/images/logo.svg" class="navbar-brand tw-w-28" />

          <Button
            icon="pi pi-times"
            text
            rounded
            class="!tw-text-white hover:!tw-bg-white/[0.1]"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          />
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav !tw-gap-2 justify-content-end flex-grow-1 pe-3">
            <li
              class="nav-item"
              v-for="(navItem, itemIndex) in filteredData"
              :key="itemIndex"
            >
              <a
                class="nav-link hover:!tw-text-secondary !tw-font-extralight tw-font-sans"
                :class="[
                  route.path == navItem.route
                    ? '!tw-text-secondary'
                    : '!tw-text-white',
                ]"
                aria-current="page"
                :href="navItem.route"
                >{{ navItem.title }}</a
              >
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { useRoute } from "#app";
import { useRouter } from "#imports";
const route = useRoute();
const router = useRouter();
const token = useCookie("token");

type User = {
  id: number;
  name: string | null;
  surname: string | null;
  email: string | null;
  role: string | null;
};

interface SidebarItem {
  title: string;
  route: string;
  role?: string[] | null;
}

const { data, userProfile } = defineProps<{
  data: SidebarItem[];
  userProfile: any;
}>();

const user: Ref<Partial<User>> = ref(userProfile);

watch(
  () => userProfile,
  (newUser) => {
    user.value = newUser;
  },
);

const filteredData = computed(() => {
  if (!token.value) {
    return data.filter(
      (item) =>
        item.route === "/auth/login" ||
        item.route === "/auth/register" ||
        item.route === "/",
    );
  }

  return data.filter((item) => {
    if (item.route === "/auth/login" || item.route === "/auth/register") {
      return false;
    }
    if (!item.role) {
      return true;
    }
    if (!user.value?.role) {
      return false;
    }
    return item.role.includes(user.value?.role);
  });
});
</script>
