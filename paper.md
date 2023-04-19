---
title: 'DataScribe: An Omeka S module for structured data transcription'
tags:
 - Omeka
 - digital humanities
 - transcription
authors:
 - name: Jessica M. Otis
   orcid: 0000-0001-5519-8331
   affiliation: 1
 - name: James Safley
   affiliation: 2
 - name: Megan Brett
   orcid: 0000-0002-7474-7196
   affiliation: 3
 - name: Lincoln Mullen
   orcid: 0000-0001-5103-6917
   affiliation: 1
affiliations:
 - name: Roy Rosenzweig Center for History and New Media, George Mason University, USA
   index: 1
 - name: Digital Scholar
   index: 2
 - name: Jefferson Library, Monticello
   index: 3
date: 19 April 2023
---

# Summary

DataScribe is a structured data transcription module that extends the functionality of the Omeka S content management system for digital exhibits. It creates an interface within the Omeka user dashboard that allows users to create projects and datasets from the images uploaded to their Omeka instance. Users then create transcription records for each item in a dataset using a transcription interface linked to customizable structured data forms. This transcribed data is exportable for analysis and/or display in other platforms. DataScribe can be downloaded through the Omeka S module registry (https://omeka.org/s/modules/), on the DataScribe website (https://datascribe.tech), or directly from the DataScribe GitHub repository (https://github.com/chnm/Datascribe-module).

Scholars often collect sources, such as government forms or institutional records, intending to transcribe them into datasets which can be analyzed or visualized. Many transcription programs such as ABBYY FineReader, Scripto for Omeka S, Tesseract, and the Zooniverse Project Builder enable the manual or automated transcription into free-form text, but not into tables of data. The DataScribe module enables scholars to manually transcribe documents directly into a structured data format. Once scholars identify the structure of the data within their sources--such as numbers, dates, or controlled vocabularies--they can create forms that constrain and verify transcriptions done in the DataScribe interface. The transcriptions are then exported in tables of clean and tidy data that can be computationally analyzed or imported into a variety of analytical software programs. Because the module builds on Omeka S, scholars can also display transcriptions alongside the source images and metadata, crowdsource transcriptions, and publish their results on the web.

Projects using DataScribe include Death by Numbers (2016-ongoing), which is transcribing the seventeenth- and eighteenth-century London Bills of Mortality, and Mapping Religious Ecologies (2018-ongoing), which is transcribing the the 1926 United States Census of Religious Bodies. As part of the development of the module, the project team also created case study documentation for how DataScribe might be used to transcribe the London Bills of Mortality (Adasme, Howlett, and Meyers 2022), documentation on a 1903 plague outbreak in Chile in both Spanish and English (Adasme 2022a; Adasme 2022b), the 1926 United States Census of Religious Bodies (Swain 2022), and the 1950 United States Census (Brett 2022).

# Acknowledgements

Development of this software was funded by the National Endowment for the Humanities (grant number HAA-266444-19).

# References

ABBYY FineReader; https://pdf.abbyy.com

Adasme, Hernán. 2022a. "Peste Bubónica en Iquique, 1903." DataScribe.tech; https://datascribe.tech/casestudies/PesteBubonica_Iquique1903.pdf

Adasme, Hernán. 2022b. "Plague in Inquique, 1903." DataScribe.tech; https://datascribe.tech/casestudies/Plague_Iquique1903.pdf

Adasme, Hernán, Daniel Howlett, and Emily Meyers. 2022. "Death by Numbers." DataScribe.tech; https://datascribe.tech/casestudies/DataScribe_BillsOfMortality_CaseStudy.pdf.

Brett, Megan. 2022. "1950 United States Census." DataScribe.tech; https://datascribe.tech/casestudies/DataScribeCaseStudy_1950CensusUS.pdf.

Death by Numbers project team. 2016-ongoing. "Death by Numbers." Roy Rosenzweig Center for History and New Media, George Mason University; https://deathbynumbers.org/.

Mapping Religious Ecologies project team. 2018-ongoing. "Mapping Religious Ecologies." Roy Rosenzweig Center for History and New Media, George Mason University; https://religiousecologies.org/.

Swain, Greta. 2022. "Religious Ecologies." DataScribe.tech; https://datascribe.tech/casestudies/CaseStudy_AmericanReligiousEcologies.pdf

Scripto; https://scripto.org

Tesseract; https://tesseract-ocr.github.io

Zooniverse Project Builder; https://www.zooniverse.org/lab.
