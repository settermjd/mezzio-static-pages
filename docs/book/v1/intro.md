# mezzio-static-pages

This component provides an, _almost_, painless way to render static pages in https://docs.mezzio.dev/mezzio/[Mezzio] applications.

*Note:* This module *does not* support [laminas-mvc](https://docs.laminas.dev/mvc/) applications.

The intent of this package is to avoid the necessity to create handlers and handler factories just to render static content.
It was motivated by various projects that I've worked on, where that seemed to be the case, at least at the time.
That approach never made sense to me, so that's that motivated me to scratch my own itch.
