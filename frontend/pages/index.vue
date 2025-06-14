<template>
  <section
    id="heading"
    class="tw-bg-[url(/images/landing-bg.svg)] tw-bg-cover tw-bg-center tw-pt-8 tw-pb-10 tw-h-screen tw-flex tw-flex-col tw-items-center tw-justify-between"
  >
    <div
      class="tw-flex tw-place-self-start tw-justify-between tw-items-center tw-gap-10 tw-w-full tw-px-10 md:tw-px-20"
    >
      <img
        alt="School Logo"
        class="tw-h-auto md:tw-max-h-16 tw-max-h-12"
        src="/images/logo.svg"
      />

      <a
        v-if="!token"
        class="cursor-pointer hover:tw-opacity-75 tw-transition tw-duration-300"
        href="/login"
      >
        <Icon color="#86C725" height="35" icon="mdi:user" width="35" />
      </a>

      <a
        v-else
        class="cursor-pointer tw-flex tw-items-center tw-gap-1 hover:tw-opacity-75 tw-transition tw-duration-300"
        href="/dashboard"
      >
        <Icon
          color="#86C725"
          height="35"
          icon="ic:twotone-dashboard"
          width="35"
        />

        <span
          class="tw-text-secondary tw-font-sans tw-text-sm tw-font-semibold"
        >
          Dashboard
        </span>
      </a>
    </div>

    <div class="tw-flex tw-flex-col tw-gap-7 tw-items-center tw-justify-center">
      <div
        class="tw-flex tw-justify-center tw-items-center tw-flex-wrap tw-gap-11"
      >
        <a
          class="tw-font-sans tw-text-white tw-text-base md:tw-text-xl tw-font-semibold hover:-tw-translate-y-2 tw-transition tw-duration-300 hover:tw-text-secondary"
          href="#documents"
        >
          Dokumenty
        </a>
        <a
          class="tw-font-sans tw-text-white tw-text-base md:tw-text-xl tw-font-semibold hover:-tw-translate-y-2 tw-transition tw-duration-300 hover:tw-text-secondary"
          href="#aboutus"
        >
          O nás
        </a>
        <a
          class="tw-font-sans tw-text-white tw-text-base md:tw-text-xl tw-font-semibold hover:-tw-translate-y-2 tw-transition tw-duration-300 hover:tw-text-secondary"
          href="#questions"
        >
          Otázky
        </a>
        <a
          class="tw-font-sans tw-text-white tw-text-base md:tw-text-xl tw-font-semibold hover:-tw-translate-y-2 tw-transition tw-duration-300 hover:tw-text-secondary"
          href="#contacts"
        >
          Kontakt
        </a>
      </div>

      <a
        class="hover:tw-scale-125 tw-transition tw-duration-300"
        href="#documents"
      >
        <Icon
          color="#86C725"
          height="40"
          icon="solar:double-alt-arrow-down-line-duotone"
          width="40"
        />
      </a>
    </div>
  </section>

  <section
    id="documents"
    class="tw-min-h-screen tw-container tw-flex tw-gap-16 tw-flex-col tw-mx-auto tw-items-center tw-justify-center tw-pt-20"
  >
    <div class="xs:tw-self-start tw-flex tw-flex-col tw-gap-3">
      <div class="tw-h-[6px] tw-w-12 tw-bg-secondary"></div>
      <h2 class="tw-font-roboto tw-font-extrabold tw-text-black">Dokumenty</h2>
    </div>

    <div
      class="tw-flex tw-w-full tw-flex-wrap tw-gap-10 tw-justify-center sm:tw-justify-start"
    >
      <FileCard v-for="file in files" :key="file.name" :file="file" />
    </div>
  </section>

  <section
    id="questions"
    class="tw-min-h-[80vh] tw-container tw-flex tw-flex-col tw-items-center tw-justify-center tw-gap-16 tw-mx-auto"
  >
    <div class="xs:tw-self-start tw-flex tw-flex-col tw-gap-3">
      <div class="tw-h-[6px] tw-w-12 tw-bg-secondary"></div>
      <h2 class="tw-font-roboto tw-font-extrabold tw-text-black">
        Často kladené otázky
      </h2>
    </div>

    <div
      id="accordions"
      class="accordion !tw-w-full tw-grid tw-grid-cols-2 tw-gap-5 tw-items-center tw-justify-center"
    >
      <div
        v-for="(question, index) in questions"
        :key="index"
        class="accordion-item !tw-bg-transparent !tw-rounded-xl !tw-mt-0 tw-col-span-2 md:tw-col-span-1"
      >
        <h2 :id="`headingcustomicon1One${index}`" class="accordion-header">
          <button
            :aria-controls="`collapsecustomicon1One${index}`"
            :data-bs-target="`#collapsecustomicon1One${index}`"
            aria-expanded="true"
            class="accordion-button collapsed !tw-py-9 !tw-font-sans !tw-text-xl !tw-px-14 !tw-rounded-tl-xl !tw-rounded-tr-xl"
            data-bs-toggle="collapse"
            type="button"
          >
            {{ question.question }}
          </button>
        </h2>
        <div
          :id="`collapsecustomicon1One${index}`"
          :aria-labelledby="`headingcustomicon1One${index}`"
          class="accordion-collapse collapse"
          data-bs-parent="#accordions"
        >
          <div
            class="accordion-body !tw-px-14 !tw-pb-9 !tw-font-sans !tw-text-xl"
          >
            {{ question.answer }}
          </div>
        </div>
      </div>
    </div>
  </section>

  <CustomLandingFooter />
</template>

<script lang="ts" setup>
import { Icon } from "@iconify/vue";
import FileCard from "~/components/sections/landing/FileCard.vue";
import useAuthStore from "~/store/auth";

const token = useAuthStore().token;

const files = ref([
  { name: "Prezentácia", url: "url1" },
  { name: "Dokumentácia", url: "url2" },
  { name: "Pokyny 2025/2026", url: "url3" },
  { name: "Harmonogram", url: "url4" },
]);

const questions = ref([
  {
    question: "Aké zameranie má naša škola?",
    answer:
      "Naša škola sa zameriava predovšetkým na informačné technológie, programovanie, správu sietí a tvorbu webových a mobilných aplikácií.",
  },
  {
    question: "Aké programovacie jazyky sa u nás učia?",
    answer:
      "Študenti sa oboznamujú s jazykmi ako Python, JavaScript, C#, PHP a SQL. Okrem toho sa venujeme aj HTML, CSS a TypeScriptu.",
  },
  {
    question: "Môžeme pracovať na vlastných projektoch?",
    answer:
      "Áno! Podporujeme študentské projekty, súťaže aj prax. Mnohí študenti pracujú na vlastných weboch, hrách alebo IoT riešeniach s Arduino a ESP32.",
  },
  {
    question: "Ako prebieha odborná prax?",
    answer:
      "Odbornú prax absolvujete v reálnych firmách alebo v rámci školských projektov. Spolupracujeme s IT firmami, startupmi aj neziskovkami.",
  },
  {
    question: "Máme možnosť zúčastniť sa súťaží?",
    answer:
      "Áno, naši študenti sa pravidelne zúčastňujú súťaží ako iBobor, Zenit, Junior Internet alebo Hackathony. Podporujeme iniciatívu a kreativitu.",
  },
  {
    question: "Používame aj moderné technológie ako AI alebo IoT?",
    answer:
      "Určite! V rámci výučby sa stretávame s konceptami umelej inteligencie, strojového učenia, spracovania dát, senzorov a mikrokontrolérov.",
  },
]);
</script>

<style lang="scss" scoped>
.accordion {
  &-item {
    border: 1px solid rgba(176, 176, 192, 0.3);
  }

  &-button {
    background-color: transparent;
    margin-left: auto;
    border-radius: 1rem;

    &:after {
      content: "";
      display: inline-block;
      background-color: #86c725;
      background-image: url(/icons/plus.svg);
      background-repeat: no-repeat;
      background-position: center;
      background-size: 24px 24px;
      width: 32px;
      height: 32px;
    }
  }

  &-button:not(.collapsed) {
    background-color: #86c725;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    color: white;

    &::after {
      background-color: #ffff;
      background-image: url(/icons/minus.svg);
    }
  }

  &-item:not(.accordion-button.collapsed) .accordion-body {
    background-color: #86c725;
    border-bottom-right-radius: 0.75rem;
    border-bottom-left-radius: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
  }
}
</style>
