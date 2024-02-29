---
layout: page
title: Usability and Evaluation
author: "John Lee"
order: 61
week: 6
---

-   [Introduction](#introduction)
-   [Usability --- what is it?](#usability-what-is-it)
    -   [How measure it?](#how-measure-it)
-   [Various parameters](#various-parameters)
    -   [Task](#task)
    -   [User](#user)
    -   [Social context](#social-context)
-   [Don Norman: usability in depth](#don-norman-usability-in-depth)
-   [Evaluation](#evaluation)
    -   [Effects of speed and irregularity](#effects-of-speed-and-irregularity)
    -   [Use of particular presentation methods](#use-of-particular-presentation-methods)
    -   [Assessment of fit with users' expectations](#assessment-of-fit-with-users-expectations)
-   [Techniques](#techniques)
    -   ["Ethnomethodological" observation](#ethnomethodological-observation)
    -   ["How was it for you?" questionnaires](#how-was-it-for-you-questionnaires)
    -   ["think-aloud" protocol studies](#think-aloud-protocol-studies)
    -   [carefully organised, counterbalanced user trials](#carefully-organised-counterbalanced-user-trials)
    -   [heavy-duty statistics](#heavy-duty-statistics)
    -   ["Think-aloud" protocols: issues](#think-aloud-protocols-issues)
    -   [distinction between satisfaction and effectiveness](#distinction-between-satisfaction-and-effectiveness)
    -   ["objective is to track the reactions of the user to the system"](#objective-is-to-track-the-reactions-of-the-user-to-the-system)
    -   [can be either free-form or structured](#can-be-either-free-form-or-structured)
    -   [identify positive and negative aspects of the user's experience](#identify-positive-and-negative-aspects-of-the-users-experience)
    -   [try to anticipate, but be prepared for flexibility](#try-to-anticipate-but-be-prepared-for-flexibility)
-   [Other aspects of evaluation](#other-aspects-of-evaluation)
-   [Sources and Resources](#sources-and-resources)

## Introduction

In this lecture, we move from looking at the technology for building web sites, to the various ways in which a web site can be evaluated. The term "usability" is employed here, but as noted below we interpret this fairly widely (as is common in the literature).

## Usability --- what is it?

This is sometimes surprisingly controversial. It has to do with how the web site and a user from the intended user population will work together to achieve the result the designer intended. This can be seen in terms of a number of measures, and people can disagree over their relative importance.

_Efficiency_ is often seen as an obvious example. How many mouse clicks, etc., does it take for the user to get the information they need, or complete the operation the designer (or the designer's client) wants them to complete, etc.?

Also _effectiveness_: how well does the site succeed in helping (or inducing) users to do what was wanted?

_User satisfaction_ is another thing often measured, but often simply on the assumption that a satisfied user is more likely to do what the site design assumes they will do.

A good many questions need to be disentangled when thinking about effectiveness and usability. Suppose a web site is intended to sell books:

-   should its effectiveness simply be measured in terms of the number of books it sells?
-   If it is redesigned, does the redesign stand or fall entirely on whether it sells more books?
-   Does it matter whether the users now like the site more? What if they like it more but buy less books?
-   What if they like it less, but for some reason they buy more books from it?

Suppose they do buy more books:

-   is that because of the web site?
-   or because of the sudden release of a lot of interesting books?
-   or a general economic upturn?
-   or something else?

### How measure it?

From the above, we see that a whole range of different things might be taken as measures of usability. But once we have decided on which measures to use, there is still the question of how to obtain the values. Below, we will consider a range of techniques, but these can range from the very direct (e.g. sitting with a user and probing in detail what they do and how they react) to very hands-off but nonetheless detailed (e.g. logging the user's every action in log files via appropriate modification of the server and/or suitable javascripts etc.).

These kinds of techniques can produce huge and problematic amounts of data: problematic in terms both of volume and of interpretation. What does the data _mean_, and how, on the basis of it, do we decide what to do differently in the site design? These questions, of course, are largely common to all computing applications (and a great many other things), not just web sites.

## Various parameters

It's useful to bear in mind that the situation in which a web site is used is invariably a good deal more complex than it might look at first sight. There are a number of parameters that one should take into account in thinking about how it is used and why it is used as it is. Most salient among these (though by no means all of them) are the following:

### Task

What is the user trying to achieve? This isn't always the same thing as what the site design assumes the user is trying to achieve. Rather than buy a book, the user might be simply trying to find out its ISBN number. The designer might not want especially to help with that task, but it may still be important to recognise that it significantly affects the behaviour of users. Also, the designer might want to think about how to modify the user's task, e.g. by putting devices in place that will try to entrap the user into looking at, and perhaps buying, books that would otherwise have been ignored. A site that is purely an "information" site, not trying to sell anything (e.g. a museum site), might be thought to have no such hidden agenda to modify the user's task; but in fact such sites often have a hidden _educational_ agenda, to "sell" a particular message or point of view on a topic, and the site design techniques that are needed may have surprising similarities to commercial sites as a result.

### User

Who is the user? What kind of person? All sorts of issues are hidden under questions like this. Is the site for children? Academics? The "general public"? Who are the latter? Do they really exist? Is it perhaps the case that people all fall into categories that have significant differences in terms of their interaction with web sites? In that case, is _personalisation_, or _adaptivity_ an important feature of one's site? Should it show different things to different people, in different ways? If so, how do you determine what kind of person a given user is? Nowadays, an increasing amount of research is going into whether various measures of "personality" can be more or less surreptitiously deployed to match users to presentation styles by the use of small questionnaires, analysis of the user's behaviour in some apparently unrelated activity (playing a small game perhaps), etc.

All of this tends to assume a rather dynamic site. But perhaps for some users, with some tasks, an entirely static site can be just as effective - and of course probably much cheaper to build. Note that users and tasks come in pairs: very often the same user (or kind of user, perhaps) will behave quite differently with a different task (or kind of task). The combinatorics of possibilities for adaptive sites can therefore become rather worrying.

A final, _but by no means least important_ issue concerning users is accessibility for disabled users, e.g. the partially sighted or colour-blind. This is something that should _always_ be given very careful thought when designing a site, and the recent standards and guidelines on the subject give it considerable prominence. In Europe, **recent legislation makes accessibility a legal obligation on web sites that provide information**, so that material provided graphically will have to have an alternative accessible to the blind, etc. (see <http://www.disability.gov.uk/> for the legalities and <http://www.w3c.org/WAI/> for technical approaches to accessible web design -- a discussion at <https://inviqa.com/blog/why-is-accessibility-important> suggests that the legalities are really not very clear).

### Social context

Recall from the topic of IT and Society that interaction with technology does not occur in isolation. Increasingly, of course, it is difficult to distinguish between web sites and information systems generally, since the latter are now so often sprouting a web-based "front end". Much depends on the social context of the interaction. If all the above variables are held constant (at least, given a typically coarse approach to categorising users and tasks) then one may well find that reactions to a site vary radically between different social settings in which the web site may be encountered.

This is a major factor, when one considers that web sites are possibly accessed from anywhere in the world. Globalisation proceeds apace, no doubt, but cultural diversity is still blessedly rife. Desirable though this is, it can create major problems for the web designer, who should try to ensure that as far as possible his site remains accessible, usable, inoffensive, even attractive to the whole range of possible users. But not only this, the designer should perhaps also consider what kinds of social changes his site could bring about. Fanciful? Not necessarily, if one considers that the widespread uptake of something like online grocery shopping could have fairly extensive consequences, and the precise _ways_ in which it is made available could affect this considerably. (The designer should consider this if only because it may be possible to envisage that people's behaviour is changed by the success of the site in a way that makes the site itself less attractive to them.)

Many of these issues are bound up with _requirements capture_ --- a process that is supposed to precede design and inform with details about what the site or system is expected to do, for whom, and with what result.

Requirements capture for a web site depends on addressing questions such as the above, to become as clear as possible about the objectives of the site design. Of course, these will never be completely precise, and will be subject to re-assessment as the design and deployment of the site progress.

## Don Norman: usability in depth

An approach to usability that is perhaps best represented by Don Norman (see e.g. <http://cogsci.ucsd.edu/~norman/DNMss/Being_Analog.html>), as well as [Jakob Neilsen](http://www.useit.com/) and some others, takes a deep view of the relationship between an artefact and its user. This kind of approach applies to kettles and doorknobs as much as computing-based systems, as indeed indicated by Norman's famous book on _The Design of Everyday Things_ and much of the discussion on his web sites.

This view demands an integration of cognitive and social perspectives, to envisage the user as a complex being interacting with many aspects of the world simultaneously. Often the focus is on what the user most naturally and transparently does when interacting, without the need for conscious deliberation.

A key concept in this view is that of _affordance_ : a doorknob _affords_ turning, and/or perhaps pulling; a button on a computer interface affords clicking, a slider affords dragging, etc. The designer might ask what his interface affords (or in simple terms, what the user will most obviously try to do with it at first sight), and in particular whether it affords the things he wants the user to do.

If affordances are ill-judged, the user ends up doing the wrong thing, probably at a crucial moment (as one often pulls a door that has a handle on it, only to find it needs to be pushed --- whereas a simple plate on the door would have afforded pushing in the first place).

Some of Norman's discussions are in fact closely related, though conducted in a radically different language, to Heidegger's discussions of _Dasein_ and the transparency of experience until some event of breakdown. Norman also sometimes invokes the notion of _flow_, popularised by Csikszentmihalyi (cf. <http://www.brainchannels.com/thinker/mihaly.html>), which refers to the idea of someone being absorbed in an activity in a way characterised by high engagement and high transparency. There is much in this area that invites the label of _cognitive ergonomics_, analogously to the kind of ergonomics that seeks to design out the tendency of workstations to cause repetitive strain injuries, etc.

Norman's recent work is tending more to suggest positive guidelines for design, but it is often difficult to apply these theories to concrete instances. It's also difficult to derive from them specific techniques for evaluation. But they do set an important context of thinking, and a rich source of concepts, when working in this area.

## Evaluation

By "evaluation" we mean some sort of procedure that a designer (or specialist evaluator) goes through in order to find out how a site or system measures up against some of the criteria we've been considering. Sometimes this is done by academics and consultants as research to derive general guidelines for site design. Here we are more concerned with its use by practising designers as part of the routine process of site design and implementation.

A distinction is often drawn between two kinds (or uses) of evaluation: _formative_ **and** _summative_. Formative evaluation is undertaken, usually with prototypes, as part of the design process of a site or system, to help determine how it should be developed best to suit its intended users. Summative evaluation is applied to a finished system, after deployment, to find out how well it functions, and perhaps how it influences the culture of the organisation in which it is used, etc.

Our focus here is naturally on formative evaluation, which is also part of the generic idea of _iterative system design_. This model assumes that design iterates through a series of prototypes, each being subjected to formative evaluation which helps to determine the design of the next. (Our programme for the design of an e-commerce web system is a simplified 2-stage iterative process, with a formative evaluation step between the "alpha" and "beta" prototypes.)

Evaluation is in many ways closely associated with requirements capture, in that these should share many concepts about the nature of the relevant tasks, users, contexts, etc. A system is evaluated against the requirements it was supposed to meet. This process is itself iterative, and may lead to re-assessment of the requirements or some of the shared concepts.

In planning evaluation, one needs to arrive at some relatively settled and agreed characterisation of the design and requirements, etc.; but it should not be thought that there is any definitively _correct_ description to be found. Requirements capture and evaluation are themselves processes that need to be designed for a given situation, and in practice have no separate "scientific" status.

Evaluation (and requirements) can be relatively narrow or wide in scope. For example, there can be more or less relative focus on cognitive or social levels. An emphasis on the social requires in-depth study of a particular, e.g. organisational, context. Evaluation of the cognitive can be conducted in a more limited way, focusing on individuals and their specific interaction with the system.

A cognitive focus allows addressing of specific issues such as:

### Effects of speed and irregularity

What happens if the system reacts very slowly? What if it is sometimes slow and sometimes fast? What if certain operations are fast, but others are then unexpectedly slow? Can we predict and control the effects of such factors (which may not themselves be under our control) by considerations deriving from a _cognitive model_ of the user; i.e. an account of how the user perceives, apprehends, processes and provides various kinds of information? How important is feedback to the user during periods of inactivity? How critical is correct synchronisation, if different things (e.g. sounds and movement) are supposed to be happening at the same time?

### Use of particular presentation methods

Is it best to present information in the form of text, or graphically? If text, is it good to arrange the text in particular ways? Are certain fonts better than others? Or colours? Should we have sound, or will it just be confusing? What kinds of mixtures of these things will and won't work? --- Some such questions can be addressed by knowing things about the ways the perceptual apparatus of humans processes e.g. colours and sounds. Some can be addressed by reference to a cognitive model, as suggested above. Detailed techniques such as reaction-timing and even eye-tracking might be used in investigating these issues.

Often there is no clear rationale, but one seems to observe that some things are more effective than others (on some definition of "effective") and often the only way to recognise this is a combination of intuition and experience with empirical observation of users in particular settings. (It's hardly ever possible to design much of what a real system does purely on the basis of theory, or even by analogy with some other situation one assumes to be similar. Particular situations always turn out to be different in unexpected ways.)

### Assessment of fit with users' expectations

Finally here, we note that users do not come to a system as blank slates, waiting for information to be fed to them. On the contrary, they often have very clear expectations of what a site will give them. These expectations may have many sources: past experience, books, press articles, word of mouth, etc. They form part of the cultural background of users in particular situations, and can be very hard to pin down, but they often will have a radical effect on how a user perceives a site. (This can be a worry in relation to a website that may be viewed by users in any part of the world, but often nothing other than extended experience after implementation will provide enough information about all these background factors.)

No matter how well designed in theory, a site may fail compared to a far poorer one if it is simply much less the kind of thing that the users expect. The users may in such cases need to contribute much more effort to understand or use the site, or simply the look of it may put them off so that they don't even try.

Usually, the effects are more subtle, however, so various techniques (from questionnaires to interaction with dummy sites) may be used to probe what users are expecting and investigate whether this is affecting their responses to a given design.

## Techniques

Techniques of usability evaluation are many and various. However, there are a few general classes which it's useful to know about. Some of these we have run into already under IT and Society or related topics. A selection of the best known are as follows, but see also usability-related web sites and other resources (some of which are noted below):

### "Ethnomethodological" observation

An increasingly popular technique. Ethnomethodology is at root the study of societies by becoming as far as possible a member of them and looking at them in huge detail from the "inside". In usability terms, this concept is always highly diluted and according to some purists does not really apply, but it is used quite commonly to refer to the detailed study of social situations of technology use. The evaluator will ideally work very intensively in an organisation for some time, and try to get into a position where a system being introduced can be looked at really from the point of view of the user, rather than that of the designer. This can help in identifying the nature and root causes of effects the technology may have within the organisation, but also more specifically how individuals will react to varying parameters of the user interaction provided by the system.

### "How was it for you?" questionnaires

This slightly facetious label is intended to characterise the sometimes rather superficial approaches often adopted to measuring _user satisfaction_. In these cases, it is important, though often omitted, e.g to consider carefully how the user will interpret questions, and how deeply the questions are probing the user's experience, rather than giving them the opportunity to say something quickly and get away from the investigator! Particularly fraught, though also common, is the use of web-based questionnaires, where the situation in which they are answered is subject to no control at all.

### "think-aloud" protocol studies

Here, the user is encouraged or required to verbalise (speak) continuously while using a system, to probe how they are reacting to it. This can be surprisingly effective --- one might think that the need to talk continuously would be a distraction, but users often seem able after a while to "forget" that they are doing this. However, it's always a requirement that one try to show that the verbalisation is not affecting the task itself in some way that means it would be reacted to quite differently without the thinking aloud.

### carefully organised, counterbalanced user trials

This is an approach favoured by many who come from a background in experimental psychology. The objective is often to obtain data that statistical techniques can be meaningfully used on (see next), but sometimes a more qualitative design can be used. In any case, the argument is that the variables relevant to behaviour with the system can be isolated and studied in separate experimental "conditions". Commonly, this is used in conjunction with very detailed behavioural measurements, e.g. "response latencies" (reaction times), and sometimes automated logging. Usually a consequence of aiming to use statistics is that numbers of subjects need to be relatively large. There is recently a strong tendency to argue that, at least in formative evaluation, most of the insight can be obtained from a small sample, and hence just a few users will be enough to work with (cf "heuristic evaluation").

### heavy-duty statistics

Often, an argument is perceived as being stronger if it is founded on statistical treatments of substantial bodies of data. There are a large number of high-powered treatments available, and some can be very effective. However, a problem always arises with interpretation of the results, since it depends on the assumptions of the original experiment (e.g. that the conditions are genuinely independent). It happens very often that the situations where web sites and other systems are put into use are too complex for experimental conditions to be effectively controlled. Then, an option is to conduct the experiment under laboratory conditions; but now the study will often be open to the charge that the results will not hold when we try to apply them back out in the real world. This is of course a trade-off that affects many areas of engineering.

## "Think-aloud" protocols: issues

Think-aloud protocols are one of the simplest and often most revealing kinds of study to implement, and can be very useful for dealing with web sites. They will most likely figure prominently in the formative evaluation work of the class. Often they are combined with short questionnaires, given immediately before and after the exercise, which can help to establish the user's expectations and can help to find out various of their impressions of the experience that they had not mentioned while involved in it. They can also be used with "paper prototypes", and are closely related to "participatory evaluation" (<https://www.betterevaluation.org/methods-approaches/approaches/participatory-evaluation>). The following are good points to note when attempting the use of think-aloud techniques:

### distinction between satisfaction and effectiveness

It's not that satisfaction is a bad thing to measure, but beware of confusing it with effectiveness. Satisfaction can be misleading to everyone, including the user. An apparently satisfied user may be one who enjoyed the site but still has not achieved what they wanted (or, perhaps even more importantly, what _you_, the designer, wanted).

### "objective is to track the reactions of the user to the system"

Try to avoid the user becoming distracted by e.g. the external environment, or other things on the machine (MSN, email, etc.), or idle chatter. Focus on the system and the task needs somehow to be maintained (though one can try to establish whether it would drift anyway, even if the think-aloud were not in progress; and whether, if it drifts, it can easily be brought back).

### can be either free-form or structured

One can simply let the user loose on the system, with an instruction to keep talking, and see what happens. But also, one can "prompt" the user in various ways, e.g. to get them to try a particular feature that they hadn't noticed, or to get their thinking aloud to address some aspect of the experience that they hadn't mentioned. This can end up being almost like a "structured interview" based on a questionnaire-style pro-forma used by the investigator. The more structured approach tends to be more time-efficient, and sometimes more accurate in its effects, but obviously the danger is that it distorts the user's behaviour through being too intrusive, or "leads" them to behave in a way quite unlike anything the unprompted user would ever do. So the main principles are that one needs to _prompt and probe_ but somehow as far as possible _without_ intruding --- this can be a fairly tricky balancing-act. ­ Bear in mind that some of the issues may best be deferred to a "debriefing" questionnaire.

Should clearly identify, as observer, the _task_ the user is performing It's an important point that the task of the user cannot be assumed to be the task the web site design anticipates. The user will have their own idea of what they are trying to do, and this may be quite difficult to pin down. Still, one has to try. Some of this may be addressed in a pre-session questionnaire. It's useful to try to identify dimensions of "success" in the task: what does the user think is "good", and why? When are they pleased with something, when not? This shades into the following ...

### Identify positive and negative aspects of the user's experience

The user's reactions may be exaggerated, or may (more likely) be subdued and subtle. In the latter case, it can be quite delicate to investigate shades of positive and negative aspects of the user's experience, but these are sometimes good guides to reworking of the site to achieve a much more satisfying --- and effective --- result.

### Try to anticipate, but be prepared for flexibility

This is perhaps very closely related to prompting without intruding. One should try to anticipate what the user will do, and how one might try to understand their reactions to various contingencies, but in the event the user will be in at least some respects fairly unpredictable. So it's important to be flexible enough to adapt one's line of prompting to something perhaps not at all anticipated by the original structure of ideas for prompts.

## Other aspects of evaluation

In the above, we have concentrated on _"Usability"_. However, other things have to be evaluated as well. These may include _practicability_  and _marketability_ . Techniques for evaluating these things may be specific and different from those used to assess usability --- from software profiling to various business modelling techniques --- but there is overlap in some areas. In particular, marketability and commercial viability is likely to relate to usability.

Some of these issues can also be addressed through the use of questionnaires, and techniques such as "cognitive walk-through". This is usually a design approach which may be closely associated with requirements capture, based on a kind of think-aloud protocol using a surface-level mock-up of the proposed system, perhaps built using Powerpoint or Director, which can be helpful in addressing major issues for later usability evaluation.

## Sources and Resources

There are hundreds of web sites that have interesting and useful material relating to usability evaluation. Here are just a few ...

-   The classic Jakob Neilsen again: <http://www.useit.com/>
-   US government advice on usability methods and techniques.
    -   <https://www.usability.gov/how-to-and-tools/methods/index.html>
-   This one is related to a book by _Dix et al_. It's good for detailed tips on using specific evaluation techniques, and there is other useful material on the site (and in the book). <http://www.hcibook.com/hcibook/links/linksch11.html>
-   Discussion of the then new international ISO usability standard (2004-8).
    -   <https://www.userfocus.co.uk/articles/ISO23973.html>
-   Some resources at a GitHub site: <https://github.com/peiyaoh/hci-ux-learning-resources>>
-   An excellent collection of resources at the Interaction Design Foundation. This is one of the best sets of resources available: <https://www.interaction-design.org/literature>
-   Finally. The company called _User Interface Engineering_ seems to be a good source of useful discussions and pointers concerning, fairly specifically, the design of e-commerce websites. This link is to their archive of often fascinating articles on particular topics. They also have an interesting blog feature. (Disclaimer: no-one connected with our programme has any relationship with this company.)
    -   [User Interface Engineering articles](https://articles.uie.com)
