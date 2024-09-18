<script setup lang="ts">
import { onMounted, onUnmounted, ref, type DefineComponent } from "vue";
import Logo from "./components/utilities/Logo.vue";
import Mdi_gmail from "./components/icons/socials/mdi_gmail.vue";
import Mdi_linkedin from "./components/icons/socials/mdi_linkedin.vue";
import Mdi_phone from "./components/icons/socials/mdi_phone.vue";
import Mdi_whatsapp from "./components/icons/socials/mdi_whatsapp.vue";
import Heading from "./components/utilities/Heading.vue";
import TextBody from "./components/utilities/TextBody.vue";
import PrimaryButton from "./components/utilities/PrimaryButton.vue";
import OutlineButton from "./components/utilities/OutlineButton.vue";
import Title from "./components/utilities/Title.vue";
import Mdi_github from "./components/icons/link/mdi_github.vue";
import Mdi_open_in_new from "./components/icons/link/mdi_open_in_new.vue";
import Mdi_map_marker_radius_outline from "./components/icons/contact/mdi_map_marker_radius_outline.vue";
import Mdi_phone_outline from "./components/icons/contact/mdi_phone_outline.vue";
import Mdi_email_outline from "./components/icons/contact/mdi_email_outline.vue";
import Mdi_arrow_up from "./components/icons/link/mdi_arrow_up.vue";

const isDark = ref<boolean>(true);
const navToggle = ref<boolean>(false);
const isScroll = ref<boolean>(false);
const activeStack = ref<'tech' | 'tool'>('tech')

const name = ref<string>('');
const email = ref<string>('');
const phone = ref<string>('');
const message = ref<string>('');
interface formResponseType {
  status: string;
  message: string;
  errors?: string[];
}
const formResponse = ref<formResponseType | null>(null);
const isLoading = ref<boolean>(false)

onMounted(() => {
  let savedTheme = localStorage.getItem('theme')
  if (savedTheme) {
    isDark.value = savedTheme === 'dark' ? true : false
  }
  setTheme()

  // set scroll event
  window.addEventListener('scroll', () => {
    isScroll.value = window.scrollY >= 10 ? true : false
  })
})

onUnmounted(() => {
  window.removeEventListener('scroll', () => { })
})

const setTheme = (): void => {
  let htmlTagClass = isDark.value ? 'dark' : ''
  document.getElementsByTagName('html')[0].setAttribute('class', `${htmlTagClass}`)

  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const changeTheme = (): void => {
  isDark.value = !isDark.value;
  setTheme()
};

const getSocialValue = (name: string) => {
  return socialsLinks.find((social) => social.name === name)?.value
}

const sendEmail = async () => {
  isLoading.value = true
  try {
    const response = await fetch('https://brainiacerudite.com/api/', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        phone: phone.value,
        message: message.value,
      }),
    });

    const data = await response.json();
    formResponse.value = data;
    // log
    if (data.status === 'success') {
      console.log('Message sent successfully:', data.message);
    } else if (data.status === 'error') {
      console.log('Failed to send message:', data.message);
      if (data?.errors) {
        console.error('Error details:', data?.errors);
      }
    }

    // reset after sending
    name.value = ''
    email.value = ''
    phone.value = ''
    message.value = ''
  } catch (error) {
    console.error('Error:', error);
    formResponse.value = {
      status: 'error',
      message: 'There was a network error. Please try again later.',
    };
  } finally {
    isLoading.value = false
  }
}

type navItemsType = {
  name: string;
  link: string;
}
const navItems: navItemsType[] = [
  { name: "Home", link: "#home" },
  { name: "About", link: "#about" },
  { name: "Skills", link: "#skills" },
  { name: "Projects", link: "#projects" },
  { name: "Contact", link: "#contact" },
]

type SocialName = 'gmail' | 'linkedin' | 'phone' | 'whatsapp';
type socialsType = {
  name: SocialName;
  value: string;
}
const socialsLinks: socialsType[] = [
  { name: 'gmail', value: 'mailto:brainiacerudite@gmail.com' },
  { name: 'linkedin', value: 'https://www.linkedin.com/in/brainiace' },
  { name: 'phone', value: 'tel:+2348109099612' },
  { name: 'whatsapp', value: 'https://wa.me/+2348109099612' },
];

type socialIconComponentsType = Record<SocialName, DefineComponent<{}, {}, {}, {}, {}>>
const socialIconComponents: socialIconComponentsType = {
  gmail: Mdi_gmail,
  linkedin: Mdi_linkedin,
  phone: Mdi_phone,
  whatsapp: Mdi_whatsapp,
};

type stacksType = { name: string; icon: string }
const techStacks: stacksType[] = [
  { name: 'html5', icon: '/images/stacks/html5/Light.svg', },
  { name: 'css', icon: '/images/stacks/css/Light.svg', },
  { name: 'js', icon: '/images/stacks/js/Light.svg', },
  { name: 'php', icon: '/images/stacks/php/Light.svg', },
  { name: 'typescript', icon: '/images/stacks/typescript/Light.svg', },
  { name: 'laravel', icon: '/images/stacks/laravel/Light.svg', },
  { name: 'nodejs', icon: '/images/stacks/nodejs/Light.svg', },
  { name: 'vuejs', icon: '/images/stacks/vuejs/Light.svg', },
  { name: 'quasar', icon: '/images/stacks/quasar/Light.svg', },
  { name: 'nuxtjs', icon: '/images/stacks/nuxtjs/Light.svg', },
  { name: 'jquery', icon: '/images/stacks/jquery/Light.svg', },
  { name: 'sass', icon: '/images/stacks/sass/Light.svg', },
  { name: '', icon: '/images/stacks/tailwind/Light.svg', },
  { name: '', icon: '/images/stacks/bootstrap5/Light.svg', },
]

const toolStacks: stacksType[] = [
  { name: 'npm', icon: '/images/stacks/npm/Light.svg', },
  { name: 'vs', icon: '/images/stacks/vs/Light.svg', },
  { name: 'github', icon: '/images/stacks/github/Light.svg', },
  { name: 'git', icon: '/images/stacks/git/Light.svg', },
  { name: 'postman', icon: '/images/stacks/postman/Light.svg', },
  { name: 'mysql', icon: '/images/stacks/mysql/Light.svg', },
  { name: 'mongodb', icon: '/images/stacks/mongodb/Light.svg', },
  { name: 'pwa', icon: '/images/stacks/pwa/Light.svg', },
  { name: 'figma', icon: '/images/stacks/figma/Light.svg', },
]

type projectsType = {
  name: string;
  img: string;
  website?: string;
  github?: string;
  stacks: Array<'vuejs' | 'quasar' | 'nuxtjs' | 'reactjs' | 'php' | 'laravel' | 'nodejs' | 'mysql' | 'mongodb'>
}
const projects: projectsType[] = [
  {
    name: 'Brainiac Portfolio',
    img: '/images/projects/brainiacerudite.com_ 1.png',
    website: 'https://brainiacerudite.com',
    github: 'https://github.com/brainiacerudite/brainiacerudite_website',
    stacks: ['vuejs']
  },
  {
    name: 'BB Camp Reg Form',
    img: '/images/projects/bbcamp.brainiacerudite.com_.png',
    website: 'https://bbcamp.brainiacerudite.com',
    github: 'https://github.com/brainiacerudite/BB_camp_reg_form',
    stacks: ['reactjs', 'php', 'mysql']
  },
  {
    name: 'RBDouble Glazing',
    img: '/images/projects/www.rbdoubleglazing.co.uk_.png',
    website: 'https://www.rbdoubleglazing.co.uk',
    stacks: ['php']
  },
  {
    name: 'Alwifaqrentacar',
    img: '/images/projects/www.alwifaqrentacar.com_.png',
    website: 'https://alwifaqrentacar.com',
    stacks: ['nuxtjs', 'laravel', 'mysql']
  },
  {
    name: 'PLP Lift Truck Peter Borough',
    img: '/images/projects/www.plplifttruckspeterborough.co.uk_.png',
    website: 'https://www.plplifttruckspeterborough.co.uk',
    stacks: ['laravel', 'mysql']
  },
  {
    name: 'Stack34 Predicta',
    img: '/images/projects/stake34.com_.png',
    website: 'https://stake34.com',
    stacks: ['reactjs', 'laravel', 'mysql']
  },
  {
    name: 'Rbxcenter',
    img: '/images/projects/test.brainiacerudite.com_.png',
    website: 'https://test.brainiacerudite.com',
    stacks: ['vuejs', 'nodejs', 'mongodb']
  },
  {
    name: 'ATL Auto Ng',
    img: '/images/projects/www.atlautong.com_.png',
    website: 'https://atlautong.com',
    stacks: ['laravel', 'mysql']
  },
  {
    name: 'Arbitrage Options App',
    img: '/images/projects/smartmockups_lpx1m37a.png',
    website: 'https://app.arbitrageoptions.io',
    stacks: ['quasar', 'laravel', 'mysql']
  },
  {
    name: 'Arbitrage Options',
    img: '/images/projects/arbitrageoptions.io_.png',
    website: 'https://arbitrageoptions.io',
    stacks: ['laravel', 'mysql']
  },
  {
    name: 'Repostads App',
    img: '/images/projects/repostads-cross-platform-app.png',
    website: 'https://app.repostads.com',
    stacks: ['quasar', 'laravel', 'mysql']
  },
  {
    name: 'Adegoke Ezekiel Art Gallery',
    img: '/images/projects/tosin_index.html.png',
    stacks: []
  },
  {
    name: 'Belcoed Official Website',
    img: '/images/projects/Belcoed-landing-page.png',
    website: 'http://belcoed.edu.ng',
    stacks: ['vuejs', 'php', 'mysql']
  },
  {
    name: 'Business Checklist',
    img: '/images/projects/Business-Checklists-landing-page.png',
    stacks: ['laravel', 'mysql']
  },
]

const resumePath: string = '/cv/Oluwasegun_Brainiac_Resume.pdf'
</script>

<template>
  <div class="top"></div>
  <header class="fixed w-full top-0 left-0 z-40 transition-all duration-300 ease-in-out px-3 py-4 lg:py-6"
    :class="{ '!py-2 bg-light-secondary-color shadow-light dark:bg-dark-secondary-color dark:shadow-dark lg:!py-4': isScroll }">
    <div class="container mx-auto">
      <div class="flex justify-between items-center gap-2">
        <Logo />
        <!-- nav actions -->
        <div class="flex items-center gap-4 ml-auto lg:order-1 lg:ml-0">
          <select id="lang" class="text-light-heading-color dark:text-dark-heading-color">
            <option
              class="bg-light-background-color text-light-heading-color dark:bg-dark-background-color dark:text-dark-heading-color"
              value="en">
              En
            </option>
            <option
              class="bg-light-background-color text-light-heading-color dark:bg-dark-background-color dark:text-dark-heading-color"
              value="ar">
              Ar
            </option>
            <option
              class="bg-light-background-color text-light-heading-color dark:bg-dark-background-color dark:text-dark-heading-color"
              value="yr">
              Yr
            </option>
          </select>
          <button @click="changeTheme()"
            class="p-1 w-12 bg-light-secondary-color rounded-full transition-all duration-300 ease-in-out dark:bg-dark-secondary-color"
            :class="{ '!bg-light-background-color dark:!bg-dark-background-color': isScroll }">
            <span class="theme-toggle-icon transition-all duration-300 ease-in-out"
              :class="{ 'active': !isDark }"></span>
          </button>
        </div>
        <!-- mobile nav toggler -->
        <button @click="navToggle = !navToggle" class="nav-toggle-btn lg:hidden" :class="{ 'active': navToggle }">
          <span class="one"></span>
          <span class="two"></span>
          <span class="three"></span>
        </button>

        <!-- nav -->
        <nav
          class="fixed z-10 top-0 w-full h-full grid place-items-center transition-all duration-700 ease-nav-buzier bg-light-secondary-color dark:bg-dark-secondary-color lg:relative lg:visible lg:left-0 lg:bg-transparent dark:lg:bg-transparent"
          :class="{ 'left-0 visible': navToggle, 'left-full invisible': !navToggle }">
          <ul class="text-center lg:flex lg:items-center lg:gap-6">
            <li class="my-12 lg:my-auto" v-for="navItem in navItems" :key="navItem.link">
              <a class="text-3xl font-extrabold text-light-heading-color dark:text-dark-heading-color lg:text-base"
                :href="navItem.link">
                {{ navItem.name }}.
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <main>
    <section id="home" class="mt-44 lg:mt-20">
      <div v-show="isDark"
        class="absolute -z-10 h-full w-full max-h-[585px] max-w-[639px] -left-[40%] -top-[5%] bg-gradient-to-r from-[#6C9FF440] to-[#05288F70] rotate-[46.9deg] rounded-[190px] blur-[250px] lg:-left-[10%] lg:-top-[10%]">
      </div>
      <div class="container mx-auto">
        <div class="flex flex-col gap-2 lg:flex-row lg:items-center lg:justify-between">
          <div
            class="px-3 -translate-y-4 text-light-heading-color dark:text-dark-heading-color md:text-center lg:w-1/2 lg:text-left">
            <h2 class="mb-3 text-2xl font-bold lg:mb-4 lg:text-2xl"><span class="text-2xl lg:text-3xl">👋</span> Hi
              There, I’m</h2>
            <h1 class="mb-4 text-5xl font-bold !leading-[1.25] lg:mb-8 lg:text-6xl">Oluwasegun Thomas.</h1>
            <p
              class="mb-4 text-base font-medium leading-[1.8] text-light-text-color dark:text-dark-text-color lg:mb-8 lg:leading-8">
              Welcome to my
              creative
              corner! I'm Thomas, also known as Brainiac Erudite in the coding world. With
              several
              years of experience, I turn innovative ideas into reality.</p>
            <div class="flex items-center space-x-4 md:justify-center lg:justify-start">
              <span class="text-base font-medium">Get In Touch</span>
              <div class="flex items-end space-x-4">
                <a v-for="social in socialsLinks" :key="social.name" :href="social.value" target="_blank"
                  class="flex items-center">
                  <component :is="socialIconComponents[social.name]"
                    class="fill-light-heading-color dark:fill-dark-heading-color" />
                </a>
              </div>
            </div>
          </div>
          <div class="w-full mx-auto max-w-[640px] lg:right-16 lg:top-16">
            <div
              class="absolute -z-10 h-[40%] w-full max-h-[469px] max-w-[429px] -bottom-[10%] bg-gradient-to-r from-[#6C9FF440] to-[#05288F70] rounded-[190px] blur-[70px] transition-all duration-100 delay-200 ease-in opacity-70 lg:h-full lg:w-full lg:right-[10%] lg:top-[25%]">
            </div>
            <img v-if="isDark" class="relative stacks-animation aspect-square object-contain object-center lg:scale-90"
              src="/images/dark_hero_img_2x.png" alt="Oluwasegun">
            <img v-else
              class="relative stacks-animation aspect-square object-contain object-center scale-90 -mt-4 lg:scale-[0.85]"
              src="/images/light_hero_img_2x.png" alt="Oluwasegun">
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="py-20 lg:py-24">
      <div class="container mx-auto">
        <div class="flex items-center px-3 lg:gap-6">
          <div class="hidden lg:w-[45%] lg:block">
            <figure class="ml-[8%] rounded-2xl max-w-96 max-h-96">
              <img class="w-full h-full object-cover" src="/images/about_img_2x.png" alt="about me">
            </figure>
          </div>
          <div class="lg:relative lg:pl-12 lg:w-[70%] lg:order-2">
            <Title>
              ABOUT ME
            </Title>
            <Heading>Need a Creative Product? I can Help You!</Heading>
            <TextBody>
              Hi! I’m Oluwasegun Thomas, also known as Brainiac Erudite in the coding world, and I’m a
              developer who has passion for building clean web applications with intuitive functionalities. I enjoy the
              process of turning ideas into reality using creative solutions. I’m always curious about learning new
              skills, tools, and concepts. In addition to working on various solo full stack projects, I have worked
              with creative teams, which involves daily stand-ups and communications, source control and collaboration,
              and project management.
            </TextBody>
            <div class="lg:flex lg:justify-start lg:items-center lg:gap-6">
              <PrimaryButton link href="#contact">Hire me</PrimaryButton>
              <OutlineButton link :href="resumePath" download>Download cv</OutlineButton>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="skills" class="py-20 lg:py-24">
      <div class="container mx-auto">
        <div class="flex items-center px-3 flex-col lg:flex-row lg:gap-8">
          <div class="mb-12 lg:relative lg:pl-12 lg:w-[55%] lg:mb-0">
            <Title>MY SKILLS</Title>
            <Heading>What My Programming Skills Included?</Heading>
            <TextBody>I develop simple, intuitive, and responsive user interfaces that help users get things done with
              less
              effort and time using these technologies. I’m always looking forward to learning new skills and expanding
              my
              expertise.</TextBody>
            <div
              class="relative w-max mx-auto flex items-center p-1 rounded-full z-10 bg-light-secondary-color shadow-light dark:bg-dark-secondary-color dark:shadow-dark before:content-[''] before:absolute before:top-1 before:bottom-1 before:bg-dark-primary-color before:rounded-full before:transition-all before:duration-300 before:ease-in-out before:-z-10 lg:mx-0"
              :class="{ 'before:left-1 before:w-[48%]': activeStack === 'tech', 'before:left-[50%] before:w-[48%]': activeStack === 'tool' }">
              <button
                class="px-7 py-2 text-base font-extrabold transition-all duration-300 ease-in-out text-light-heading-color dark:text-dark-heading-color"
                :class="{ '!text-dark-heading-color': activeStack === 'tech' }"
                @click="activeStack = 'tech'">Skills</button>
              <button
                class="px-7 py-2 text-base font-extrabold transition-all duration-300 ease-in-out text-light-heading-color dark:text-dark-heading-color"
                :class="{ '!text-dark-heading-color': activeStack === 'tool' }"
                @click="activeStack = 'tool'">Tools</button>
            </div>
          </div>
          <div :class="{ 'hidden': activeStack !== 'tech' }"
            class="flex flex-wrap justify-center items-center gap-4 stacks-animation lg:w-[45%]">
            <div
              class="relative w-20 h-20 grid place-items-center rounded-xl bg-light-secondary-color shadow-light dark:bg-dark-secondary-color dark:shadow-dark"
              v-for="stack in techStacks" :key="stack.name">
              <img class="" :src="stack.icon" :alt="stack.name">
            </div>
          </div>
          <div :class="{ 'hidden': activeStack !== 'tool' }"
            class="flex flex-wrap justify-center items-center gap-4 stacks-animation lg:w-[45%]">
            <div
              class="relative w-20 h-20 grid place-items-center rounded-xl bg-light-secondary-color dark:bg-dark-secondary-color"
              v-for="stack in toolStacks" :key="stack.name">
              <img class="" :src="stack.icon" :alt="stack.name">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="projects" class="py-20 lg:py-24">
      <div class="container mx-auto">
        <div class="px-3 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
          <div class="lg:relative lg:pl-12 lg:pr-2">
            <Title>FEATURED WORKS</Title>
            <Heading>See My Works Which Will Amaze You!</Heading>
            <TextBody>I develop the best quality website that serves for the long-term. Well-documented, clean, easy and
              elegant interface helps any non-technical clients.</TextBody>
          </div>
          <div v-for="project in projects" :key="project.name"
            class="relative max-w-[362px] max-h-[272px] justify-self-center self-end rounded-xl overflow-hidden group bg-light-secondary-color shadow-light dark:bg-dark-secondary-color dark:shadow-dark">
            <div
              class="absolute z-0 -bottom-full h-full w-full bg-gradient-to-b from-[#00000005] to-black opacity-50 transition-all duration-300 ease-in-out group-hover:bottom-0">
            </div>
            <div
              class="absolute z-10 -bottom-full h-full w-full p-4 flex flex-col justify-between transition-all duration-150 ease-in-out group-hover:-bottom-0">
              <div class="flex items-center justify-end gap-2">
                <a v-if="project.website" :href="project.website" target="_blank"
                  class="rounded-full w-8 h-8 bg-white text-black grid place-items-center transition-all duration-300 ease-in-out hover:bg-dark-primary-color hover:text-white">
                  <Mdi_open_in_new class="fill-black hover:fill-white" />
                </a>
                <a v-if="project.github" :href="project.github" target="_blank"
                  class="rounded-full w-8 h-8 bg-white text-black grid place-items-center transition-all duration-300 ease-in-out hover:bg-dark-primary-color hover:text-white">
                  <Mdi_github class="fill-black hover:fill-white" />
                </a>
              </div>
              <div class="space-y-3">
                <div class="text-sm font-bold text-white">
                  {{ project.name }}
                </div>
                <div class="flex items-center gap-1">
                  <div class="bg-white text-black text-xs font-medium rounded-full px-2 py-0.5"
                    v-for="stack in project.stacks" :key="stack">
                    {{ stack }}
                  </div>
                </div>
              </div>
            </div>
            <img class="w-full h-full object-cover" :src="project.img" :alt="project.name">
          </div>
        </div>
      </div>
    </section>

    <section id="contact" class="py-20 lg:py-24">
      <div class="container mx-auto">
        <div class="flex items-center px-3 flex-col lg:flex-row lg:gap-8">
          <div class="mb-12 lg:w-1/2 lg:mb-0">
            <div class="mb-8 lg:relative lg:pl-12">
              <Title>CONTACT</Title>
              <Heading>Have Any Project? Please Drop a Message</Heading>
              <TextBody>Get in touch and let me know how I can help. Fill out the form and I’ll be in touch as soon as
                possible.</TextBody>
            </div>
            <div class="flex items-start gap-4 mb-4">
              <Mdi_map_marker_radius_outline class="fill-light-heading-color dark:fill-dark-heading-color" />
              <div>
                <h3 class="mb-2 text-base font-black text-light-heading-color dark:text-dark-heading-color">
                  Address:
                </h3>
                <address class="text-base font-normal not-italic leading-[1.6]">
                  No. 1 Bamboo Street, Igbo Agbonin, Ogbomoso, Nigeria
                </address>
              </div>
            </div>
            <div class="flex items-start gap-4 mb-4">
              <Mdi_phone_outline class="fill-light-heading-color dark:fill-dark-heading-color" />
              <div>
                <h3 class="mb-2 text-base font-black text-light-heading-color dark:text-dark-heading-color">
                  Phone:
                </h3>
                <a :href="getSocialValue('phone')" class="text-base font-normal not-italic leading-[1.6]">
                  {{ getSocialValue('phone')?.slice(4) }}
                </a>
              </div>
            </div>
            <div class="flex items-start gap-4 mb-4">
              <Mdi_email_outline class="fill-light-heading-color dark:fill-dark-heading-color" />
              <div>
                <h3 class="mb-2 text-base font-black text-light-heading-color dark:text-dark-heading-color">
                  Email:
                </h3>
                <a :href="getSocialValue('gmail')" class="text-base font-normal not-italic leading-[1.6]">
                  {{ getSocialValue('gmail')?.slice(7) }}
                </a>
              </div>
            </div>
            <div class="flex flex-wrap justify-start items-center gap-4 px-10">
              <div class="w-8 h-8 p-2 rounded-full bg-light-heading-color dark:bg-dark-heading-color"
                v-for="social in socialsLinks" :key="social.name">
                <a :href="social.value" target="_blank" class="flex items-center">
                  <component :is="socialIconComponents[social.name]"
                    class="fill-light-background-color dark:fill-dark-background-color" />
                </a>
              </div>
            </div>
          </div>
          <form @submit.prevent="sendEmail" method="post"
            class="mx-auto max-w-[28.125rem] w-full rounded-xl space-y-5 py-6 px-6 shadow-light bg-light-secondary-color text-light-heading-color dark:shadow-dark dark:bg-dark-secondary-color dark:text-dark-heading-color lg:w-1/2">
            <div class="w-full flex flex-col">
              <label for="name" class="ml-1 mb-2 text-sm font-extrabold">Name</label>
              <input type="text" id="name" name="name" v-model="name" required
                class="px-4 py-2 rounded-lg text-base font-normal text-light-primary-color bg-light-input-background-color placeholder:text-input-placeholder-color focus:outline-none focus:border-light-primary-color focus:ring-1 focus:ring-light-primary-color dark:bg-dark-input-background-color"
                placeholder="e.g. John Doe">
            </div>
            <div class="w-full flex flex-col">
              <label for="email" class="ml-1 mb-2 text-sm font-extrabold">Email</label>
              <input type="email" id="email" name="email" v-model="email" required
                class="px-4 py-2 rounded-lg text-base font-normal text-light-primary-color bg-light-input-background-color placeholder:text-input-placeholder-color focus:outline-none focus:border-light-primary-color focus:ring-1 focus:ring-light-primary-color dark:bg-dark-input-background-color"
                placeholder="e.g. johndoe@gmail.com">
            </div>
            <div class="w-full flex flex-col">
              <label for="phone" class="ml-1 mb-2 text-sm font-extrabold">Phone</label>
              <input type="number" id="phone" name="phone" v-model="phone" required
                class="px-4 py-2 rounded-lg text-base font-normal text-light-primary-color bg-light-input-background-color placeholder:text-input-placeholder-color focus:outline-none focus:border-light-primary-color focus:ring-1 focus:ring-light-primary-color dark:bg-dark-input-background-color"
                placeholder="e.g. 2340123456789">
            </div>
            <div class="w-full flex flex-col">
              <label for="message" class="ml-1 mb-2 text-sm font-extrabold">Message</label>
              <textarea id="message" name="message" v-model="message" required
                class="px-4 py-2 rounded-lg text-base font-normal text-light-primary-color bg-light-input-background-color placeholder:text-input-placeholder-color focus:outline-none focus:border-light-primary-color focus:ring-1 focus:ring-light-primary-color dark:bg-dark-input-background-color"
                placeholder="Write Message" rows="4"></textarea>
            </div>
            <div class="w-full">
              <p v-if="formResponse && formResponse.status === 'error'" class="text-[#e33f3f] text-sm mb-2 text-center">
                {{ formResponse?.message }}
              </p>
              <p v-if="formResponse && formResponse.status === 'success'"
                class="text-[#2fb32f] text-sm mb-2 text-center">
                {{ formResponse?.message }}
              </p>
              <PrimaryButton type="submit" :disabled="isLoading || !name || !email || !phone || !message"
                class="disabled:opacity-30 disabled:cursor-not-allowed lg:!max-w-full">SEND
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer
    class="w-full px-3 py-3 text-center bg-light-secondary-color shadow-light dark:bg-dark-secondary-color dark:shadow-dark lg:py-4">
    <div class="container mx-auto">
      <div class="text-center flex flex-col items-center justify-between lg:flex-row">
        <Logo class="!pr-0 mb-4 lg:mb-0" />
        <p class="text-base font-normal text-light-text-color dark:text-dark-text-color">© 2024 <a
            class="text-dark-primary-color" href="">brainiacerudite</a>. All rights reserved</p>
      </div>
    </div>
  </footer>

  <!-- Scroll to top -->
  <a href="#top"
    class="fixed z-20 bottom-6 right-6 w-10 h-10 grid place-items-center text-light-heading-color border-2 border-solid border-light-heading-color rounded-full transition-all duration-200 ease-in-out dark:text-dark-heading-color dark:border-dark-heading-color"
    :class="{ 'opacity-0 pointer-events-none translate-y-3': !isScroll, 'opacity-100 pointer-events-auto translate-y-0': isScroll }">
    <Mdi_arrow_up class="fill-light-heading-color dark:fill-dark-heading-color" />
  </a>
</template>

<style scoped>
/* theme toggler icon */
.theme-toggle-icon {
  @apply relative block left-0 w-5 h-5 rounded-full;
  box-shadow: inset 9px -6px #f5f5f5;
}

.theme-toggle-icon.active {
  left: 20px;
  box-shadow: inset 20px -20px #f9d81a;
}

/* mobile nav toggler */
.nav-toggle-btn {
  position: relative;
  transition: 0.25s ease-in-out;
  z-index: 20;
}

.nav-toggle-btn .one {
  transform-origin: left;
}

.nav-toggle-btn .three {
  transform-origin: right;
}

.nav-toggle-btn :is(.three) {
  width: 10px;
}

.nav-toggle-btn span {
  @apply block bg-light-heading-color dark:bg-dark-heading-color;
  width: 20px;
  height: 2px;
  margin: 5px;
  transition: 0.25s ease-in-out;
}

.nav-toggle-btn.active {
  transform: rotate(-45deg);
}

.nav-toggle-btn.active .one {
  transform: rotate(90deg) translate(-3px, -10px);
}

.nav-toggle-btn.active .three {
  display: none;
}

.stacks-animation {
  animation: fadeIn 0.7s ease-out forwards;
}
</style>
