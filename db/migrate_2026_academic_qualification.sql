-- 2026 admission system changes (Proposed Changes for TPg Admission System v3)
-- Mark sheet section replaced by "Academic qualification of your institution":
--   - GPA/Mark entered as two boxes (obtained "of" maximum), stored as "obtained/max"
--   - New mandatory "Classification of award" drop-down, stored per institution slot
-- Run against the tpgFront database.

ALTER TABLE avgMark
  MODIFY avgMarkByStud1 varchar(20) NULL,
  MODIFY avgMarkByStud2 varchar(20) NULL,
  MODIFY avgMarkByStud3 varchar(20) NULL,
  ADD COLUMN awardClass1 varchar(40) NULL AFTER avgMarkByStud3,
  ADD COLUMN awardClass2 varchar(40) NULL AFTER awardClass1,
  ADD COLUMN awardClass3 varchar(40) NULL AFTER awardClass2;
