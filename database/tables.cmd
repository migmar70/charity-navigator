SET OUTPUT=tables.sql
SET FOLDER=table

IF EXIST "%output%" DEL /q "%output%"

TYPE %FOLDER%\category.sql>>"%output%"
TYPE %FOLDER%\cause.sql>>"%output%"
TYPE %FOLDER%\celebrity.sql>>"%output%"
TYPE %FOLDER%\celebrityorganization.sql>>"%output%"
TYPE %FOLDER%\celebrityrelationship.sql>>"%output%"
TYPE %FOLDER%\celebritytype.sql>>"%output%"
TYPE %FOLDER%\country.sql>>"%output%"
TYPE %FOLDER%\countrycharity.sql>>"%output%"
TYPE %FOLDER%\countryorganization.sql>>"%output%"
TYPE %FOLDER%\list.sql>>"%output%"
TYPE %FOLDER%\listorganization.sql>>"%output%"
TYPE %FOLDER%\organization.sql>>"%output%"
TYPE %FOLDER%\region.sql>>"%output%"
TYPE %FOLDER%\version.sql>>"%output%"
TYPE %FOLDER%\user.sql>>"%output%"
TYPE %FOLDER%\mycharity.sql>>"%output%"

