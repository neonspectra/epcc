EPCC is Copyleft © 2026 [neon](https://neosynth.net/meta/contact/). Except where otherwise noted, this repo is licensed under a [Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International license](https://creativecommons.org/licenses/by-nc-sa/4.0/).

This work is a derivative work based on [previous work by Arthur Moore and other authors](https://github.com/Eclipse-Phase-Unofficial/ep-character-creator) licensed under a [Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License](https://creativecommons.org/licenses/by-nc-sa/3.0/deed.en_US). Changes were made.

The full copyright notice of the prior work is reproduced below:
```markdown
# Copyright (c) 2013-2019
# CC BY-NC-SA 3.0
This work is licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License.
To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/ or send a letter to
Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.

# GNU LGPLv3
All work done by Arthur Moore is licensed under the GNU Lesser General Public License v3.0 in addition to the CC BY-NC-SA 3.0 License.

## Corollary / Warning about older works
As I have moved many files, they may appear to have my name attached to them, but I am not the original creator.  In some cases, I have modified the files, but since the file started as one under the older license, it is licensed under the original CC BY-NC-SA 3.0 License until it is re-written.

# Libraries
This work uses the Laravel, Vue, and other libraries.  All of which are licensed under an MIT (or BSD) license. If you believe this work is using a non MIT/BSD licensed library please contact us so we can correct this error.
```

---

2026-01-14 Note: 

The statement by previous maintainer Arthur Moore indicates that the work done by them is licensed under LGPL, but this is not legally feasible for two reasons:
1. Eclipse Phase is copyright to [Posthuman Studios](https://posthumanstudios.com/), and game contents for every prior iteration of EPCC have been licensed to the community under a Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International (or, in earlier publishings, 3.0 Unported) license. Derivatives of this tool cannot be relicensed under a different license.
2. In practice, you cannot sublicense code contributions to open source projects under both CC and LGPL in this manner because these licenses are not compatible. LGPL is intended for use with libraries, decomposable assets, and atomic subcomponents (not individual contributions).
    - Downstream licensees still have to license the original work under the original CC BY-NC-SA license, so what this means is that (legally speaking) any downstream fork from [Arthur Moore's fork](https://github.com/Eclipse-Phase-Unofficial/ep-character-creator) would be beholden to the terms of both LGPL and CC-BY-NC-SA for any downstream forks. This is not possible to do, and thus the license isn't valid.
    - This fully invalidates any reason to use a copyleft license like LGPL in the first place because this code now can't technically be licensed by *anyone* under the license as written.

However, as I have no respect for copyright, I am going to choose to disregard Arthur's LGPL notice and make use of this code anyway.

If you are Arthur Moore and you are reading this, I'm assuming that your intent was to use LGPL to create broader copyleft freedoms than those enforced by BY-NC-SA but in practice you've done the opposite and made your contributions fully copyright to yourself and no one else. If you are interested in relicensing your contributions correctly as allowed by the original BY-NC-SA license, [hit me up so we can fix this](https://neosynth.net/meta/contact/). Not that it really matters, given that none of us are making any money off this fan tool 😅.
